<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        $wishlists = Wishlist::with('product.farmer')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function store(Product $product)
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Product added to your wishlist!');
    }

    public function destroy(Product $product)
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Product removed from your wishlist.');
    }
}