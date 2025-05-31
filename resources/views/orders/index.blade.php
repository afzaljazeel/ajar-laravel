@extends('layouts.profile')

@section('title', 'My Orders')

@section('inner-content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Your Orders</h1>

    @if ($orders->count())
        <div class="space-y-10">
            @foreach ($orders as $order)
                @continue($order->status === 'dispatched') {{-- skip completed orders here --}}

                <div class="border rounded-lg shadow bg-white p-6">
                    {{-- Order Header --}}
                    <div class="mb-4 border-b pb-2">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Order #{{ $order->id }} 
                        </h2>
                        <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                        <p class="text-sm text-gray-700 mt-1 font-medium">Total: LKR{{ number_format($order->total, 2) }}</p>
                    </div>

                    {{-- Order Items --}}
                    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4 border p-3 rounded shadow-sm">
                                <div class="w-20 h-28 bg-gray-100 rounded overflow-hidden">
                                    <img src="{{ asset('storage/' . ($item->product->coverImage->image_path ?? $item->product->images->first()->image_path ?? 'placeholder.jpg')) }}"
                                    alt="{{ $item->product->name }}"
                                    class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800 truncate">
                                        {{ $item->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600">Size: {{ $item->size ?? '-' }}</p>
                                    <p class="text-sm text-gray-600">Variant: {{ $item->variant ?? '-' }}</p>
                                    <p class="text-sm text-gray-700 mt-1">
                                        {{ $item->quantity }} × LKR{{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Status Progress Tracker --}}
                    @php
                        $statuses = ['pending', 'accepted', 'processing', 'in_transit'];
                        $currentStatusIndex = array_search($order->status, $statuses);
                    @endphp

                    <div class="flex items-center justify-between mt-6 px-2">
                        @foreach ($statuses as $i => $status)
                            <div class="flex flex-col items-center text-center flex-1 relative">
                                <div class="w-4 h-4 rounded-full z-10 {{ $i <= $currentStatusIndex ? 'bg-green-300' : 'bg-gray-300' }}"></div>
                                <span class="text-xs mt-2 capitalize text-gray-700">{{ str_replace('_', ' ', $status) }}</span>
                                <span class="text-xs text-gray-500 mt-1">
                                    {{ $i <= $currentStatusIndex ? $order->updated_at->format('M d') : '—' }}
                                </span>

                                @if ($i < count($statuses) - 1)
                                    <div class="absolute top-2 left-1/2 w-full h-px bg-gray-300 z-0"></div>
                                @endif
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
