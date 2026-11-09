<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $hasCompletedPurchase = OrderItem::where('product_id', $product->id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'completed')
            ->exists();

        if (!$hasCompletedPurchase) {
            throw ValidationException::withMessages([
                'review' => 'You can review this product only after completing an order that includes it.',
            ]);
        }

        $alreadyReviewed = ProductReview::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        if ($alreadyReviewed) {
            throw ValidationException::withMessages([
                'review' => 'You have already reviewed this product.',
            ]);
        }

        ProductReview::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Your review was submitted successfully!');
    }
}