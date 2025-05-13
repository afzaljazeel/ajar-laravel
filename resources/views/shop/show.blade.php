@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 gap-10">

    {{-- Gallery --}}
    <div class="space-y-4">
        <div class="w-full aspect-[3/4] overflow-hidden rounded border">
            <img id="main-image"
                 src="{{ asset('storage/' . ($product->images->first()->image_path ?? 'placeholder.jpg')) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover object-center transition duration-300">
        </div>

        <div class="flex gap-3 overflow-x-auto">
            @foreach ($product->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}"
                     class="h-20 w-28 object-cover rounded border cursor-pointer hover:ring-2 ring-gray-800 transition"
                     onclick="document.getElementById('main-image').src=this.src;">
            @endforeach
        </div>
    </div>

    {{-- Details --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
        <p class="text-gray-600 text-sm mb-1">Category: {{ $product->category->name ?? '-' }}</p>

        {{-- Pricing --}}
        @if ($product->sale_price)
            <p class="text-2xl font-semibold text-gray-900 mt-4">
                <span class="line-through text-gray-400 mr-2">${{ number_format($product->price, 2) }}</span>
                ${{ number_format($product->sale_price, 2) }}
            </p>
        @else
            <p class="text-2xl font-semibold text-gray-900 mt-4">
                ${{ number_format($product->price, 2) }}
            </p>
        @endif

        {{-- Description --}}
        <div class="mt-6">
            <p class="text-gray-700 text-sm leading-relaxed">{{ $product->description }}</p>
        </div>

        {{-- Sizes --}}
        @if ($product->sizes)
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-gray-700 mb-1">Choose Size:</h4>
                <div id="size-options" class="flex flex-wrap gap-2">
                    @foreach ($product->sizes as $size)
                        <button type="button"
                                class="px-3 py-1 border rounded text-sm bg-white text-gray-700 hover:bg-gray-100 transition"
                                onclick="selectOption('size', '{{ $size }}', this)">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Variants --}}
        @if ($product->variants)
            <div class="mt-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-1">Choose Variant:</h4>
                <div id="variant-options" class="flex flex-wrap gap-2">
                    @foreach ($product->variants as $variant)
                        <button type="button"
                                class="px-3 py-1 border rounded text-sm bg-white text-gray-700 hover:bg-gray-100 transition"
                                onclick="selectOption('variant', '{{ $variant }}', this)">
                            {{ $variant }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Cart + Favorite --}}
        @auth
            @if (!auth()->user()->is_admin)
                {{-- Add to Cart --}}
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" name="size" id="selected-size">
                    <input type="hidden" name="variant" id="selected-variant">

                    <button type="submit"
                            class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-black transition w-full">
                        Add to Cart
                    </button>
                </form>

                {{-- Favorite --}}
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit"
                            class="w-full text-center px-6 py-2 border rounded text-sm text-gray-700 hover:bg-gray-100 transition">
                        ❤️ Add to Favorites
                    </button>
                </form>
            @else
                <p class="text-red-600 text-sm mt-6 font-semibold">
                    Admins cannot add to cart or favorite items.
                </p>
            @endif
        @else
            <div class="mt-6 space-y-3">
                <a href="{{ route('login') }}"
                   class="block bg-gray-800 text-white text-center px-6 py-2 rounded hover:bg-black transition">
                    Login to Add to Cart
                </a>
                <a href="{{ route('register') }}"
                   class="block text-center border px-6 py-2 rounded text-gray-700 hover:bg-gray-100 transition">
                    Register Now
                </a>
            </div>
        @endauth
    </div>
</div>

{{-- Script for size/variant selection --}}
<script>
    function selectOption(type, value, element) {
        document.querySelectorAll(`#${type}-options button`).forEach(btn => {
            btn.classList.remove('bg-gray-900', 'text-white');
            btn.classList.add('bg-white', 'text-gray-700');
        });
        element.classList.remove('bg-white', 'text-gray-700');
        element.classList.add('bg-gray-900', 'text-white');
        document.getElementById(`selected-${type}`).value = value;
    }
</script>
@endsection
