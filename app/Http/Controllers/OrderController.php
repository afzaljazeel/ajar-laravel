<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // GET /api/orders
    public function index()
    {
        $user = auth()->user();

        $orders = $user->orders()
            ->with('items.product.images')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
    // 
    public function store()
    {
        $user = Auth::user();

        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $total = 0;

        // Pre-calculate total
        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            $total += $price * $item->quantity;
        }

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total' => $total,
        ]);

        // Add order items
        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'size' => $item->size,
                'variant' => $item->variant,
                'quantity' => $item->quantity,
                'price' => $price,
            ]);
        }

        // Clear cart
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('orders')->with('success', 'Your order has been placed!');
    }
}