<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'size' => 'nullable|string',
            'variant' => 'nullable|string',
        ]);

        $cart = auth()->user()->cart()->create([
            'product_id' => $product->id,
            'size' => $request->input('size'),
            'variant' => $request->input('variant'),
            'quantity' => 1, // or support custom qty
        ]);

        return redirect()->route('cart')->with('success', 'Product added to cart.');
    }

}
