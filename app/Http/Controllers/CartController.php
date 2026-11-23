<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, Product $product)
    {
        abort_unless(Auth::user()->role === 'customer', 403);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

          if (
        $product->expiration_date &&
        \Carbon\Carbon::parse($product->expiration_date)->lt(\Carbon\Carbon::today())
    ) {
        return back()->with(
            'error',
            'Sorry, this product has already expired and cannot be added to your cart.'
        );
    }

        if ($product->quantity < 1) {
            return back()->with('error', 'This product is out of stock.');
        }

        $quantity = (int) $request->quantity;

        if ($quantity > $product->quantity) {
            return back()->with(
                'error',
                'The requested quantity exceeds the available stock.'
            );
        }

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        $newQuantity = $quantity + ($cartItem ? $cartItem->quantity : 0);

        if ($newQuantity > $product->quantity) {
            return back()->with(
                'error',
                'Your cart quantity would exceed the available stock.'
            );
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

       return redirect()
    ->back()
    ->with('success', 'Product added to your cart!');
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
{
    abort_unless(Auth::user()->role === 'customer', 403);
    abort_unless($cartItem->user_id === Auth::id(), 403);

    $request->validate([
        'quantity' => ['required', 'integer', 'min:1'],
    ]);

    $product = Product::findOrFail($cartItem->product_id);

    if (
        $product->expiration_date &&
        \Carbon\Carbon::parse($product->expiration_date)->lt(\Carbon\Carbon::today())
    ) {
        return response()->json([
            'success' => false,
            'message' => 'This product has already expired.'
        ], 422);
    }

    if ($request->quantity > $product->quantity) {
        return response()->json([
            'success' => false,
            'message' => 'The requested quantity exceeds the available stock.'
        ], 422);
    }

    $cartItem->update([
        'quantity' => $request->quantity,
    ]);

    return response()->json([
        'success' => true,
        'quantity' => $cartItem->quantity,
        'subtotal' => $product->price * $cartItem->quantity,
        'message' => 'Cart quantity updated successfully!'
    ]);
}

public function remove(CartItem $cartItem)
{
    abort_unless(Auth::user()->role === 'customer', 403);
    abort_unless($cartItem->user_id === Auth::id(), 403);

    $cartItem->delete();

    return response()->json([
        'success' => true,
        'message' => 'Product removed from your cart.'
    ]);
}
}