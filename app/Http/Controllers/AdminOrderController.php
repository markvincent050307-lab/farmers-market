<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $query = Order::with(['user', 'items.product', 'items.farmer']);

        // Search by order ID or customer name
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->get();

        $totalOrders = Order::count();
        $paidOrders = Order::where('payment_status', 'paid')->count();
        $pendingPayments = Order::where('payment_status', 'pending')->count();

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'paidOrders',
            'pendingPayments'
        ));
    }

    public function show(Order $order)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $order->load(['user', 'items.product', 'items.farmer']);

        return view('admin.orders.show', compact('order'));
    }
}