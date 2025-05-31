<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    // Show admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    //show admin profile
    public function profile()
    {
        return view('admin.profile');
    }

    public function orders()
    {
        $orders = Order::with(['items.product.images', 'user'])
            ->whereNotIn('status', ['dispatched', 'cancelled'])
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // Update Order Status
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,processing,in_transit,dispatched,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated to ' . ucfirst(str_replace('_', ' ', $order->status)) . '.');
    }

    // Completed (Dispatched) Orders
    public function successfulOrders()
    {
        $orders = Order::with(['items.product.images', 'user'])
                    ->where('status', 'dispatched')
                    ->latest()
                    ->get();

        return view('admin.orders.successful', compact('orders'));
    }

    // Cancelled Orders
    public function cancelledOrders()
    {
        $orders = Order::with(['items.product.images', 'user'])
                    ->where('status', 'cancelled')
                    ->latest()
                    ->get();

        return view('admin.orders.cancelled', compact('orders'));
    }

    public function statistics()
    {
        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
        $completedRevenue = \App\Models\Order::where('status', 'dispatched')->sum('total');
        $userCount = \App\Models\User::where('is_admin', false)->count();

        return view('admin.statistics', compact('totalOrders', 'pendingOrders', 'completedRevenue', 'userCount'));
    }


}
