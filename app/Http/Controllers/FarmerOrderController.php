<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FarmerOrderController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'farmer', 403);

        $orderItems = OrderItem::with(['order.user', 'product'])
            ->where('farmer_id', Auth::id())
            ->latest()
            ->get();

        return view('farmer.orders.index', compact('orderItems'));
    }

    public function updateStatus(Request $request, $id)
    {
        abort_unless(Auth::user()->role === 'farmer', 403);

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'processing',
                    'ready_for_delivery',
                    'completed',
                ]),
            ],
        ]);

        $orderItem = OrderItem::where('farmer_id', Auth::id())
            ->findOrFail($id);

        $orderItem->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('farmer.orders.index')
            ->with('success', 'Order status updated successfully!');
    }
}