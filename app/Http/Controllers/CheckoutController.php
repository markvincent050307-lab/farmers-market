<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        $validated = $request->validate([
            'payment_method' => ['required', 'in:gcash,cod'],
        ]);

        $paymentMethod = $validated['payment_method'];

        $order = DB::transaction(function () use ($paymentMethod) {
            $cartItems = CartItem::where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                return null;
            }

            $itemsToOrder = [];
            $totalCents = 0;

            foreach ($cartItems as $cartItem) {
                $product = Product::whereKey($cartItem->product_id)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw ValidationException::withMessages([
                        'cart' => 'A product in your cart is no longer available.',
                    ]);
                }

                if (
    $product->expiration_date &&
    \Carbon\Carbon::parse($product->expiration_date)->lt(\Carbon\Carbon::today())
) {
    throw ValidationException::withMessages([
        'cart' => 'The product "' .
            $product->name .
            '" has expired and cannot be purchased. Please remove it from your cart.',
    ]);
}

                if (
                    $cartItem->quantity < 1 ||
                    $cartItem->quantity > $product->quantity
                ) {
                    throw ValidationException::withMessages([
                        'cart' => 'The available stock for "' .
                            $product->name .
                            '" has changed. Please review your cart.',
                    ]);
                }

                $priceCents = (int) round(
                    (float) $product->price * 100
                );

                $totalCents += $priceCents * $cartItem->quantity;

                $itemsToOrder[] = [
                    'product' => $product,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => number_format(
                    $totalCents / 100,
                    2,
                    '.',
                    ''
                ),
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'payment_status' => 'unpaid',
            ]);

            foreach ($itemsToOrder as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'farmer_id' => $item['product']->user_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $item['product']->decrement(
                    'quantity',
                    $item['quantity']
                );
            }

            CartItem::where('user_id', Auth::id())->delete();

            return $order;
        });

        if (!$order) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        /*
         * Cash on Delivery
         */
        if ($paymentMethod === 'cod') {
            return redirect()
                ->route('orders.index')
                ->with(
                    'success',
                    'Order #' . $order->id .
                    ' was placed successfully using Cash on Delivery.'
                );
        }

        /*
         * GCash through Xendit
         */
        $secretKey = config('services.xendit.secret_key');
        $baseUrl = rtrim(
            config('services.xendit.base_url', 'https://api.xendit.co'),
            '/'
        );

        if (empty($secretKey)) {
            $this->cancelAndRestoreStock($order);

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Xendit is not configured. Please check your environment settings.'
                );
        }

        try {
            $response = Http::withBasicAuth($secretKey, '')
                ->withHeaders([
                    'api-version' => config(
                        'services.xendit.api_version',
                        '2024-11-11'
                    ),
                ])
                ->timeout(30)
                ->post($baseUrl . '/v3/payment_requests', [
                    'reference_id' => 'ORDER-' . $order->id . '-' .
                        Str::uuid(),
                    'type' => 'PAY',
                    'country' => 'PH',
                    'currency' => 'PHP',
                    'request_amount' => (float) $order->total_amount,
                    'capture_method' => 'AUTOMATIC',
                    'channel_code' => 'GCASH',
                    'channel_properties' => [
                        'success_return_url' => route('orders.index'),
                        'failure_return_url' => route('orders.index'),
                    ],
                    'description' => 'Farmers Marketplace Order #' .
                        $order->id,
                    'metadata' => [
                        'order_id' => (string) $order->id,
                    ],
                ]);

            if (!$response->successful()) {
    \Illuminate\Support\Facades\Log::error(
        'Xendit payment request failed',
        [
            'http_status' => $response->status(),
            'response_body' => $response->json(),
        ]
    );

    $this->cancelAndRestoreStock($order);

                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Unable to start the GCash payment. Please check your Xendit test account and try again.'
                    );
            }

            $paymentData = $response->json();

            $redirectUrl = collect(
                $paymentData['actions'] ?? []
            )->first(function ($action) {
                return ($action['type'] ?? '') === 'REDIRECT_CUSTOMER';
            });

            if (
                empty($paymentData['payment_request_id']) ||
                empty($redirectUrl['value'])
            ) {
                report(new \RuntimeException(
                    'Xendit response did not contain the expected payment ID and redirect URL.'
                ));

                $this->cancelAndRestoreStock($order);

                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Xendit did not return a payment page. Please check your test account configuration.'
                    );
            }

            $order->update([
                'payment_reference' => $paymentData['payment_request_id'],
                'payment_status' => 'pending',
            ]);

            return redirect()->away($redirectUrl['value']);

        } catch (\Throwable $exception) {
            report($exception);

            $this->cancelAndRestoreStock($order);

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'An error occurred while starting the GCash payment. Please try again.'
                );
        }
    }

    private function cancelAndRestoreStock(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($order->status === 'cancelled') {
                return;
            }

            $items = OrderItem::where('order_id', $order->id)->get();

            foreach ($items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product) {
                    $product->increment('quantity', $item->quantity);
                }
            }

            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'failed',
            ]);
        });
    }
}