@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-10">

    {{-- Metrics --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded shadow text-center">
            <p class="text-2xl font-bold">{{ \App\Models\Order::count() }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Orders</p>
        </div>
        <div class="bg-white p-5 rounded shadow text-center">
            <p class="text-2xl font-bold">
                LKR {{ number_format(\App\Models\Order::whereMonth('created_at', now()->month)->sum('total'), 2) }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Revenue (This Month)</p>
        </div>
        <div class="bg-white p-5 rounded shadow text-center">
            <p class="text-2xl font-bold">{{ \App\Models\User::count() }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Users</p>
        </div>
        <div class="bg-white p-5 rounded shadow text-center">
            <p class="text-2xl font-bold">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
            <p class="text-sm text-gray-500 mt-1">Pending Orders</p>
        </div>
    </div>

    {{-- Chart + Recent Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Monthly Orders Chart --}}
        <div class="bg-white p-6 rounded shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Monthly Orders</h3>
            </div>
            <canvas id="ordersChart" height="120"></canvas>
        </div>

        {{-- Recent Activity Card (Pending Orders Only) --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4"> New Pending Orders</h3>

            @php
                $recentOrders = \App\Models\Order::with('user')
                    ->where('status', 'pending')
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp

            @if ($recentOrders->count())
                <ul class="divide-y divide-gray-200">
                    @foreach ($recentOrders as $order)
                        <li class="py-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    Order #{{ $order->id }} - <span class="text-yellow-600">Pending</span>
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $order->user->name }} — {{ $order->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <a href="{{ route('admin.orders.index') }}"
                               class="text-blue-600 text-sm font-medium hover:underline">View</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-sm">No new pending orders.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@php
    $orderData = \App\Models\Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();
@endphp

<script>
    const ctx = document.getElementById('ordersChart');
    const orderData = {!! json_encode($orderData) !!};

    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const dataset = [];

    for (let i = 1; i <= 12; i++) {
        dataset.push(orderData[i] || 0);
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Orders',
                data: dataset,
                borderColor: 'black',
                backgroundColor: 'rgba(0,0,0,0.1)',
                tension: 0.4,
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 5 }
                }
            }
        }
    });
</script>
@endsection

