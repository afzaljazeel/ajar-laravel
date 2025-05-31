@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Shopping Cart</h1>

    @if ($cartItems->count())
        <div class="grid gap-6">
            @foreach ($cartItems as $item)
                <div class="flex flex-col sm:flex-row items-center gap-4 p-4 border rounded shadow-sm bg-white">
                    {{-- Product Image --}}
                    <div class="w-24 h-32 bg-gray-100 overflow-hidden rounded">
                       <img src="{{ asset('storage/' . 
                        ($item->product->coverImage->image_path ?? 
                        $item->product->images->first()->image_path ?? 
                        'placeholder.jpg')) }}"
                        alt="{{ $item->product->name }}" 
                        class="w-full h-full object-cover">
                    </div>

                    {{-- Product Info --}}
                    <div class="flex-1 w-full">
                        <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $item->product->name }}</h2>
                        <p class="text-sm text-gray-600">Size: {{ $item->size ?? '-' }}</p>
                        <p class="text-sm text-gray-600">Variant: {{ $item->variant ?? '-' }}</p>

                        {{-- Price --}}
                        @php
                            $price = $item->product->sale_price ?? $item->product->price;
                            $subtotal = $price * $item->quantity;
                        @endphp
                        <p class="mt-1 text-sm font-medium text-gray-900">Price: LKR{{ number_format($price, 2) }}</p>
                        <p class="text-sm text-gray-700">Subtotal: LKR{{ number_format($subtotal, 2) }}</p>
                    </div>

                    {{-- Quantity Update --}}
                    <form action="{{ route('cart.update', $item->product->id) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="size" value="{{ $item->size }}">
                        <input type="hidden" name="variant" value="{{ $item->variant }}">
                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                               min="1" class="w-16 text-center border rounded px-2 py-1 text-sm" />
                        <button type="submit"
                                class="text-sm bg-gray-800 text-white px-3 py-1 rounded hover:bg-black transition">
                            Update
                        </button>
                    </form>

                    {{-- Remove --}}
                    <form action="{{ route('cart.remove', $item->product->id) }}" method="POST" class="mt-2 sm:mt-0">
                        @csrf
                        <input type="hidden" name="size" value="{{ $item->size }}">
                        <input type="hidden" name="variant" value="{{ $item->variant }}">
                        <button type="submit"
                                class="text-sm text-red-600 hover:underline hover:text-red-800">
                            Remove
                        </button>
                    </form>
                </div>
            @endforeach
        </div>


        {{-- Total & Checkout --}}
        <div class="mt-8 p-4 border-t text-right space-y-2">
            <p class="text-sm text-green-600 font-medium">🎉 Free delivery on all orders!</p>
            <p class="text-lg font-semibold text-gray-800">Total: LKR{{ number_format($total, 2) }}</p>
            <a href="{{ route('checkout') }}"
            class="inline-block mt-2 bg-gray-900 text-white px-6 py-2 rounded hover:bg-black transition">
                Proceed to Checkout
            </a>
        </div>


    @else
        {{-- Empty Cart --}}
        <div class="text-center py-24">
            <p class="text-xl font-semibold text-gray-700">Your cart is empty 🛒</p>
            <a href="{{ route('shop') }}"
               class="mt-4 inline-block px-6 py-2 bg-gray-800 text-white rounded hover:bg-black transition">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection
