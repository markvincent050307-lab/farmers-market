<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Verify the callback token.
        $expectedToken = config('services.xendit.webhook_token');
        $receivedToken = $request->header('x-callback-token');

        if (
            empty($expectedToken) ||
            empty($receivedToken) ||
            !hash_equals($expectedToken, $receivedToken)
        ) {
            Log::warning('Xendit webhook rejected: invalid token.');

            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $event = $request->input('event');
        $data = $request->input('data', []);

        $paymentRequestId = $data['payment_request_id'] ?? null;
        $paymentStatus = $data['status'] ?? null;
        $referenceId = $data['reference_id'] ?? null;
        $orderId = $data['metadata']['order_id'] ?? null;
        $currency = $data['currency'] ?? null;
        $amount = $data['request_amount'] ?? null;

        if (
            empty($paymentRequestId) ||
            empty($referenceId) ||
            empty($orderId) ||
            !is_numeric($amount) ||
            !is_string($currency)
        ) {
            Log::warning('Xendit webhook rejected: incomplete payment data.');

            return response()->json([
                'message' => 'Incomplete payment data',
            ], 400);
        }

        // Find the order associated with this payment reference.
        $order = Order::where(
            'payment_reference',
            $paymentRequestId
        )->first();

        if (!$order) {
            Log::warning('Xendit webhook received for unknown payment.', [
                'payment_request_id' => $paymentRequestId,
            ]);

            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        // Verify the payment belongs to this order.
        if (
            (string) $order->id !== (string) $orderId ||
            !str_starts_with(
                $referenceId,
                'ORDER-' . $order->id . '-'
            )
        ) {
            Log::warning('Xendit webhook rejected: order reference mismatch.', [
                'order_id' => $order->id,
                'payment_request_id' => $paymentRequestId,
            ]);

            return response()->json([
                'message' => 'Payment reference mismatch',
            ], 400);
        }

        // Verify the payment amount and currency.
        $expectedAmount = (int) round(
            (float) $order->total_amount * 100
        );

        $receivedAmount = (int) round(
            (float) $amount * 100
        );

        if (
            strtoupper($currency) !== 'PHP' ||
            $receivedAmount !== $expectedAmount
        ) {
            Log::warning('Xendit webhook rejected: amount or currency mismatch.', [
                'order_id' => $order->id,
                'expected_amount' => $expectedAmount,
                'received_amount' => $receivedAmount,
                'currency' => $currency,
            ]);

            return response()->json([
                'message' => 'Payment amount or currency mismatch',
            ], 400);
        }

        // Only process payment events this application understands.
        $isSuccessfulPayment =
            $event === 'payment.capture' &&
            $paymentStatus === 'SUCCEEDED';

        $isFailedPayment =
            $event === 'payment.failure' &&
            $paymentStatus === 'FAILED';

        if (!$isSuccessfulPayment && !$isFailedPayment) {
            Log::info('Xendit webhook event ignored.', [
                'event' => $event,
                'payment_status' => $paymentStatus,
                'order_id' => $order->id,
            ]);

            return response()->json([
                'message' => 'Event ignored',
            ], 200);
        }

        DB::transaction(function () use (
            $order,
            $isSuccessfulPayment,
            $isFailedPayment
        ) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->first();

            if (!$lockedOrder) {
                return;
            }

            // Do not downgrade an already-paid order.
            if ($lockedOrder->payment_status === 'paid') {
                return;
            }

            if ($isSuccessfulPayment) {
                $lockedOrder->update([
                    'payment_status' => 'paid',
                ]);
            } elseif ($isFailedPayment) {
                $lockedOrder->update([
                    'payment_status' => 'failed',
                ]);
            }
        });

        return response()->json([
            'message' => 'Webhook processed',
        ], 200);
    }
}