<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // 🔐 Get logged-in user's orders
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('items.product')->latest()->get();
        return response()->json($orders);
    }

    // 🛒 Place a new order
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.size'       => 'nullable|string',
            'items.*.variant'    => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $total = 0;

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $itemTotal = $product->price * $item['quantity'];
            $total += $itemTotal;
        }

        $order = Order::create([
            'user_id' => $request->user()->id,
            'total'   => $total,
            'status'  => 'pending',
        ]);

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'price'      => $product->price, // Use actual price
                'size'       => $item['size'] ?? null,
                'variant'    => $item['variant'] ?? null,
            ]);
        }

        return response()->json(['message' => 'Order placed', 'order_id' => $order->id], 201);
    }
}
