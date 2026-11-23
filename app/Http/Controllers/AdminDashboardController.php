<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $totalFarmers = User::where('role', 'farmer')->count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalProducts = Product::count();

        $totalOrders = Order::count();

        $completedItems = OrderItem::where('status', 'completed')
            ->whereHas('order', function ($query) {
                $query->where(function ($paymentQuery) {
                    $paymentQuery->where('payment_status', 'paid')
                        ->orWhere('payment_method', 'cod');
                });
            });

        $totalSales = (clone $completedItems)
            ->sum(DB::raw('price * quantity'));

        $totalProductsSold = (clone $completedItems)
            ->sum('quantity');

        $farmerSales = OrderItem::select(
        'users.name as farmer_name',
        DB::raw('(order_items.price * order_items.quantity) as total_sales'),
        'orders.created_at as sale_date'
    )
    ->join('users', 'users.id', '=', 'order_items.farmer_id')
    ->join('orders', 'orders.id', '=', 'order_items.order_id')
    ->where('users.role', 'farmer')
    ->where('order_items.status', 'completed')
    ->where(function ($query) {
        $query->where('orders.payment_status', 'paid')
            ->orWhere('orders.payment_method', 'cod');
    })
    ->get();
        $completedOrders = OrderItem::where('status', 'completed')
            ->distinct('order_id')
            ->count('order_id');

        $pendingOrders = OrderItem::where('status', 'pending')
            ->distinct('order_id')
            ->count('order_id');

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

            $recentRegistrations = User::latest()
    ->limit(5)
    ->get();

$recentLogins = User::whereNotNull('last_login_at')
    ->orderByDesc('last_login_at')
    ->limit(5)
    ->get();

        return view('admin-dashboard', compact(
            'totalFarmers',
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'totalSales',
            'farmerSales',
            'totalProductsSold',
            'completedOrders',
            'pendingOrders',
            'recentOrders',
            'recentRegistrations',
'recentLogins',
        ));
    }
}