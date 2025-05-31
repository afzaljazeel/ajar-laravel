@extends('layouts.admin')

@section('title', 'Successful Orders')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Successful Orders</h1>

@if ($orders->count())
    <div class="space-y-10">
        @foreach ($orders as $order)
            <div class="bg-white border rounded shadow p-6">
                <div class="mb-2">
                    <p class="font-semibold">Order #{{ $order->id }}</p>
                    <p class="text-sm text-gray-600">User: {{ $order->user->name }} ({{ $order->user->email }})</p>
                    <p class="text-sm text-gray-600">Delivered: {{ $order->updated_at->format('F j, Y') }}</p>
                    <p class="font-medium text-green-600">Status: Dispatched</p>
                </div>

                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                    @foreach ($order->items as $item)
                        <div class="flex gap-3 border rounded p-3">
                            <img src="{{ asset('storage/' . ($item->product->coverImage->image_path ?? $item->product->images->first()->image_path ?? 'placeholder.jpg')) }}" class="w-20 h-24 object-cover rounded">
                            <div>
                                <h3 class="font-medium text-sm">{{ $item->product->name }}</h3>
                                <p class="text-xs text-gray-500">Size: {{ $item->size ?? '-' }}, Variant: {{ $item->variant ?? '-' }}</p>
                                <p class="text-sm font-semibold mt-1">{{ $item->quantity }} × Rs.{{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-gray-600">No completed orders yet.</p>
@endif
@endsection
