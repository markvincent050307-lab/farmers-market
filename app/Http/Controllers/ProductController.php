<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function shop(Request $request)
{
    abort_unless(Auth::user()->role === 'customer', 403);

   $query = Product::with(['farmer', 'reviews.user'])
    ->withAvg('reviews', 'rating')
    ->where('quantity', '>', 0)
    ->where(function ($query) {
        $query->whereNull('expiration_date')
              ->orWhereDate('expiration_date', '>=', now()->toDateString());
    });

    // Search products by name.
    if ($request->filled('search')) {
        $query->where(
            'name',
            'like',
            '%' . $request->search . '%'
        );
    }

    // Filter products by category.
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Sort products by price.
    if ($request->sort === 'price_low') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort === 'price_high') {
        $query->orderBy('price', 'desc');
    } else {
        $query->latest();
    }

    $products = $query->get();

    // Get available categories for the filter.
    $categories = Product::whereNotNull('category')
        ->where('category', '!=', '')
        ->distinct()
        ->orderBy('category')
        ->pluck('category');

    return view(
        'products.shop',
        compact('products', 'categories')
    );
}

    public function index()
    {
        abort_unless(Auth::user()->role === 'farmer', 403);

        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        abort_unless(Auth::user()->role === 'farmer', 403);

        return view('products.create');
    }

  public function store(Request $request)
{
    abort_unless(Auth::user()->role === 'farmer', 403);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'category' => [
            'required',
            'string',
            'in:Vegetables,Fruits,Grains,Root Crops,Eggs,Other Agricultural Products'
        ],
        'description' => ['nullable', 'string'],
        'price' => ['required', 'numeric', 'min:0.01'],
        'quantity' => ['required', 'integer', 'min:0'],
        'harvest_date' => ['nullable', 'date'],
        'expiration_date' => [
            'nullable',
            'date',
            'after_or_equal:harvest_date'
        ],
        'image' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048'
        ],
    ]);

    $imagePath = $request->file('image')->store('products', 'public');

    Product::create([
        'user_id' => Auth::id(),
        'name' => $validated['name'],
        'category' => $validated['category'],
        'description' => $validated['description'] ?? null,
        'price' => $validated['price'],
        'quantity' => $validated['quantity'],
        'harvest_date' => $validated['harvest_date'] ?? null,
        'expiration_date' => $validated['expiration_date'] ?? null,
        'image' => $imagePath,
    ]);

    return redirect()
        ->route('products.index')
        ->with('success', 'Product added successfully!');
}
public function updateStock(Request $request, Product $product)
{
    abort_unless(Auth::user()->role === 'farmer', 403);

    // Make sure the product belongs to the logged-in farmer.
    abort_unless($product->user_id === Auth::id(), 403);

    $validated = $request->validate([
        'quantity' => ['required', 'integer', 'min:0'],
    ]);

    $product->update([
        'quantity' => $validated['quantity'],
    ]);

    return redirect()
        ->route('products.index')
        ->with('success', 'Product stock updated successfully!');
}
public function edit(Product $product)
{
    abort_unless(Auth::user()->role === 'farmer', 403);
    abort_unless($product->user_id === Auth::id(), 403);

    return view('products.edit', compact('product'));
}

public function update(Request $request, Product $product)
{
    abort_unless(Auth::user()->role === 'farmer', 403);
    abort_unless($product->user_id === Auth::id(), 403);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'category' => [
            'required',
            'string',
            'in:Vegetables,Fruits,Grains,Root Crops,Eggs,Other Agricultural Products'
        ],
        'description' => ['nullable', 'string'],
        'price' => ['required', 'numeric', 'min:0.01'],
        'quantity' => ['required', 'integer', 'min:0'],
        'harvest_date' => ['nullable', 'date'],
        'expiration_date' => [
            'nullable',
            'date',
            'after_or_equal:harvest_date'
        ],
        'image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048'
        ],
    ]);

    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $validated['image'] = $request->file('image')
            ->store('products', 'public');
    }

    $product->update($validated);

    return redirect()
        ->route('products.index')
        ->with('success', 'Product updated successfully!');
}

}