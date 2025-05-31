@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Manage Orders</h1>

    @if (session('success'))
        <div class="mb-6 bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->count())
        <div class="space-y-10">
            @foreach ($orders as $order)
                <div class="border rounded-lg shadow bg-white p-6">
                    {{-- Order Header --}}
                    <div class="mb-4 border-b pb-2">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Order #{{ $order->id }}
                        </h2>
                        <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                        <p class="text-sm text-gray-700 mt-1 font-medium">Total: ${{ number_format($order->total, 2) }}</p>
                        <p class="text-sm text-gray-700 mt-1">Customer: {{ $order->user->name }} ({{ $order->user->email }})</p>
                    </div>

                    {{-- Order Items --}}
                    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4 border p-3 rounded shadow-sm">
                                <div class="w-20 h-28 bg-gray-100 rounded overflow-hidden">
                                    <img src="{{ asset('storage/' . ($item->product->coverImage->image_path ?? $item->product->images->first()->image_path ?? 'placeholder.jpg')) }}"
                                         class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Size: {{ $item->size ?? '-' }}</p>
                                    <p class="text-sm text-gray-600">Variant: {{ $item->variant ?? '-' }}</p>
                                    <p class="text-sm text-gray-700 mt-1">
                                        {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Status Tracker & Dropdown --}}
                    @php
                        $statuses = ['pending', 'accepted', 'processing', 'in_transit', 'dispatched', 'cancelled'];
                        $currentStatusIndex = array_search($order->status, $statuses);
                    @endphp

                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-4">
                            <div class="flex items-center gap-3 flex-wrap">
                                @foreach ($statuses as $i => $status)
                                    <span class="text-xs px-2 py-1 rounded-full {{ $i <= $currentStatusIndex ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="flex items-center gap-2">
                                <select name="status" class="border rounded px-3 py-2 text-sm">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit"
                                        class="bg-gray-900 text-white px-4 py-2 text-sm rounded hover:bg-black">
                                    Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-24">
            <p class="text-xl font-semibold text-gray-700">No orders found!</p>
        </div>
    @endif
</div>
@endsection
