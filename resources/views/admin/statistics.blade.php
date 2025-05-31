@extends('layouts.admin')

@section('title', 'Statistics Overview')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10 space-y-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-10 text-center">Statistics Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-8 text-center h-40 flex flex-col justify-center">
            <p class="text-4xl font-extrabold text-blue-700">{{ $totalOrders }}</p>
            <p class="text-base text-gray-600 mt-2">Total Orders</p>
        </div>

        <div class="bg-white rounded-lg shadow p-8 text-center h-40 flex flex-col justify-center">
            <p class="text-4xl font-extrabold text-yellow-600">{{ $pendingOrders }}</p>
            <p class="text-base text-gray-600 mt-2">Pending Orders</p>
        </div>

        <div class="bg-white rounded-lg shadow p-8 text-center h-40 flex flex-col justify-center">
            <p class="text-4xl font-extrabold text-green-700">LKR {{ number_format($completedRevenue, 2) }}</p>
            <p class="text-base text-gray-600 mt-2">Completed Revenue</p>
        </div>

        <div class="bg-white rounded-lg shadow p-8 text-center h-40 flex flex-col justify-center">
            <p class="text-4xl font-extrabold text-purple-700">{{ $userCount }}</p>
            <p class="text-base text-gray-600 mt-2">Total Users</p>
        </div>
    </div>
</div>
@endsection
