<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;


class CartController extends Controller
{
    // controller method to display cart items

    public function index()
    {
        $user = Auth::user();

        $cartItems = Cart::with('product.images')
            ->where('user_id', $user->id)
            ->get();

        // Calculate total
        $total = $cartItems->reduce(function ($carry, $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            return $carry + ($price * $item->quantity);
        }, 0);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'size' => 'nullable|string',
            'variant' => 'nullable|string',
        ]);

        $user = auth()->user();

        // Prevent admins from adding to cart
        if ($user->is_admin) {
            return back()->with('error', 'Admins cannot add to cart.');
        }

        // Check if item already exists in cart
        $existing = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->where('variant', $request->variant)
            ->first();

        if ($existing) {
            $existing->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'size' => $request->size,
                'variant' => $request->variant,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Product added to cart!');

    }

    //Update Quantity

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'variant' => 'nullable|string',
        ]);

        $user = auth()->user();

        $item = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->where('variant', $request->variant)
            ->first();

        if ($item) {
            $item->update(['quantity' => $request->quantity]);
            return back()->with('success', 'Quantity updated!');
        }

        return back()->with('error', 'Cart item not found.');
    }

    //Remove Item from Cart

    public function remove(Request $request, Product $product)
    {
        $request->validate([
            'size' => 'nullable|string',
            'variant' => 'nullable|string',
        ]);

        $user = auth()->user();

        Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->where('variant', $request->variant)
            ->delete();

        return back()->with('success', 'Item removed from cart.');
    }

}
