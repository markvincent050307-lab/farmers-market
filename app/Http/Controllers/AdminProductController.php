<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $query = Product::with('farmer');

        // Search by product name or farmer name
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('farmer', function ($farmerQuery) use ($search) {
                      $farmerQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->get();

        $totalProducts = Product::count();
        $totalFarmers = Product::distinct('user_id')->count('user_id');
        $categories = Product::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.products.index', compact(
            'products',
            'totalProducts',
            'totalFarmers',
            'categories'
        ));
    }

    public function edit(Product $product)
{
    abort_unless(Auth::user()->role === 'admin', 403);

    return view('admin.products.edit', compact('product'));
}

public function update(Request $request, Product $product)
{
    abort_unless(Auth::user()->role === 'admin', 403);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'harvest_date' => 'nullable|date',
        'expiration_date' => 'nullable|date|after_or_equal:harvest_date',
    ]);

    $product->update($validated);

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Product updated successfully!');
}

public function destroy(Product $product)
{
    abort_unless(Auth::user()->role === 'admin', 403);

    // Delete the uploaded product image.
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    // Delete the product record.
    $product->delete();

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Product deleted successfully!');
}
}