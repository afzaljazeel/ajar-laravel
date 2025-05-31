@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-6">My Wishlist</h1>

    @if ($wishlistItems->isEmpty())
        <p class="text-gray-600">You have no items in your wishlist yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($wishlistItems as $item)
                <div class="bg-white rounded shadow-sm overflow-hidden border hover:shadow-md transition">
                    <a href="{{ route('shop.show', $item->id) }}">
                        <img src="{{ asset('storage/' . ($item->coverImage->image_path ?? $item->images->first()->image_path ?? 'placeholder.jpg')) }}"
                      
                             class="w-full h-48 object-cover" alt="{{ $item->name }}">
                    </a>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-900 truncate">
                            {{ $item->name }}
                        </h2>

                        <p class="text-gray-600 text-sm mt-1">
                            @if ($item->sale_price)
                                <span class="line-through mr-1">LKR{{ number_format($item->price, 2) }}</span>
                                <span class="text-red-600 font-semibold">LKR{{ number_format($item->sale_price, 2) }}</span>
                            @else
                                LKR {{ number_format($item->price, 2) }}
                            @endif
                        </p>

                        <form method="POST" action="{{ route('wishlist.toggle', $item->id) }}" class="mt-4">
                            @csrf
                            <button class="w-full px-4 py-2 text-sm text-gray-700 border rounded hover:bg-gray-100 transition">
                                 Remove from Wishlist
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
