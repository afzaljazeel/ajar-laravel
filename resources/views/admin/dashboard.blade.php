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

    {{-- Chart --}}
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Monthly Orders</h3>
        </div>
        <canvas id="ordersChart" height="120"></canvas>
    </div>

</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('ordersChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Orders',
                data: [12, 19, 10, 15, 22, 30, 28, 23, 25, 20, 18, 26], // replace with backend later
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
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 10 }
                }
            }
        }
    });
</script>
@endsection
