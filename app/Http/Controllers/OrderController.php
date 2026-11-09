<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function cancel($id)
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        DB::transaction(function () use ($id) {
            $order = Order::where('user_id', Auth::id())
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($order->status !== 'pending') {
                throw ValidationException::withMessages([
                    'order' => 'Only pending orders can be cancelled.',
                ]);
            }

            if (
                $order->payment_method === 'gcash' &&
                $order->payment_status === 'paid'
            ) {
                throw ValidationException::withMessages([
                    'order' => 'This GCash order has already been paid. Please contact the marketplace administrator for assistance with cancellation and refund.',
                ]);
            }

            $items = OrderItem::where('order_id', $order->id)->get();

            foreach ($items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product) {
                    $product->increment('quantity', $item->quantity);
                }

                $item->update(['status' => 'cancelled']);
            }

            $order->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Your order was cancelled successfully, and the product stock was restored.');
    }
}