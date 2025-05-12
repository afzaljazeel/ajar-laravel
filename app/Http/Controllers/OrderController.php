<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // GET /api/orders
    public function index()
    {
        $orders = Order::with('items.product')->where('user_id', Auth::id())->get();
        return response()->json($orders, 200);
    }

    // POST /api/orders
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total' => 0, // calculate later
        ]);

        $total = 0;

        foreach ($validated['items'] as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $subtotal = $product->price * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);

            $total += $subtotal;
        }

        $order->update(['total' => $total]);

        return response()->json(['message' => 'Order placed successfully'], 201);
    }
}