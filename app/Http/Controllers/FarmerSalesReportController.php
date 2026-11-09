<?php

namespace App\Http\Controllers;

use App\Exports\FarmerSalesReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FarmerSalesReportController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Auth::user()->role === 'farmer', 403);

        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = $validated['start_date'] ?? now()->startOfMonth()->toDateString();
        $endDate = $validated['end_date'] ?? now()->toDateString();

        $salesQuery = OrderItem::where('farmer_id', Auth::id())
            ->where('status', 'completed')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where(function ($paymentQuery) {
                    $paymentQuery->where('payment_status', 'paid')
                        ->orWhere('payment_method', 'cod');
                })
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
            });

        $totalSales = (clone $salesQuery)->sum(DB::raw('price * quantity'));

        $totalOrders = (clone $salesQuery)
            ->distinct()
            ->count('order_id');

        $totalQuantity = (clone $salesQuery)->sum('quantity');

        $salesItems = (clone $salesQuery)
            ->with(['order.user', 'product'])
            ->latest()
            ->get();

        return view('farmer-sales-report', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalOrders',
            'totalQuantity',
            'salesItems'
        ));
    }

   public function export(Request $request)
{
    abort_unless(Auth::user()->role === 'farmer', 403);

    $validated = $request->validate([
        'start_date' => ['nullable', 'date'],
        'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
    ]);

    $startDate = $validated['start_date'] ?? now()->startOfMonth()->toDateString();
    $endDate = $validated['end_date'] ?? now()->toDateString();

    $salesItems = OrderItem::where('farmer_id', Auth::id())
        ->where('status', 'completed')
        ->whereHas('order', function ($query) use ($startDate, $endDate) {
            $query->where(function ($paymentQuery) {
                $paymentQuery->where('payment_status', 'paid')
                    ->orWhere('payment_method', 'cod');
            })
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);
        })
        ->with(['order.user', 'product'])
        ->latest()
        ->get();

    $totalSales = $salesItems->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    $totalOrders = $salesItems->pluck('order_id')->unique()->count();

    $totalQuantity = $salesItems->sum('quantity');

    $filename = 'Sales_Report_' . $startDate . '_to_' . $endDate . '.xlsx';

    return Excel::download(
        new FarmerSalesReportExport(
            $salesItems,
            $startDate,
            $endDate,
            $totalSales,
            $totalOrders,
            $totalQuantity
        ),
        $filename
    );
}
}