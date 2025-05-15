@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Your Orders</h1>

    @if ($orders->count())
        <div class="space-y-10">
            @foreach ($orders as $order)
                <div class="border rounded-lg shadow-sm bg-white p-6">
                    <div class="mb-4 border-b pb-2">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Order #{{ $order->id }} — {{ $order->status }}
                        </h2>
                        <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                        <p class="text-sm text-gray-700 mt-1 font-medium">Total: ${{ number_format($order->total, 2) }}</p>
                    </div>

                    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4 border p-3 rounded">
                                {{-- Image --}}
                                <div class="w-20 h-28 bg-gray-100 rounded overflow-hidden">
                                    <img src="{{ asset('storage/' . ($item->product->images->first()->image_path ?? 'placeholder.jpg')) }}"
                                         alt="{{ $item->product->name }}"
                                         class="w-full h-full object-cover">
                                </div>

                                {{-- Info --}}
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800 truncate">
                                        {{ $item->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600">Size: {{ $item->size ?? '-' }}</p>
                                    <p class="text-sm text-gray-600">Variant: {{ $item->variant ?? '-' }}</p>
                                    <p class="text-sm text-gray-700 mt-1">
                                        {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-24">
            <p class="text-xl font-semibold text-gray-700">You haven't placed any orders yet 🧾</p>
            <a href="{{ route('shop') }}"
               class="mt-4 inline-block px-6 py-2 bg-gray-800 text-white rounded hover:bg-black transition">
                Shop Now
            </a>
        </div>
    @endif
</div>
@endsection
