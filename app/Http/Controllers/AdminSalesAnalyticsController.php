<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminSalesAnalyticsController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        // Completed and eligible sales only
        $sales = OrderItem::where('status', 'completed')
            ->whereHas('order', function ($query) {
                $query->where(function ($paymentQuery) {
                    $paymentQuery->where('payment_status', 'paid')
                        ->orWhere('payment_method', 'cod');
                });
            });

        // Overall sales
        $totalRevenue = (clone $sales)
            ->sum(DB::raw('price * quantity'));

        $totalProductsSold = (clone $sales)->sum('quantity');

        $totalCompletedOrders = (clone $sales)
            ->distinct('order_id')
            ->count('order_id');

        // Sales for today
        $todaySales = (clone $sales)
            ->whereHas('order', function ($query) {
                $query->whereDate('created_at', today());
            })
            ->sum(DB::raw('price * quantity'));

        // Sales for this week
        $weeklySales = (clone $sales)
            ->whereHas('order', function ($query) {
                $query->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            })
            ->sum(DB::raw('price * quantity'));

        // Sales for this month
        $monthlySales = (clone $sales)
            ->whereHas('order', function ($query) {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            })
            ->sum(DB::raw('price * quantity'));

        // Best-selling products
        $bestSellingProducts = (clone $sales)
            ->select(
                'product_id',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(price * quantity) as total_revenue')
            )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Top-performing farmers
        $topFarmers = (clone $sales)
            ->select(
                'farmer_id',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(price * quantity) as total_revenue')
            )
            ->with('farmer')
            ->groupBy('farmer_id')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        return view('admin.sales.analytics', compact(
            'totalRevenue',
            'totalProductsSold',
            'totalCompletedOrders',
            'todaySales',
            'weeklySales',
            'monthlySales',
            'bestSellingProducts',
            'topFarmers'
        ));
    }
}