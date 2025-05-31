@extends('layouts.app')

@section('title', $product->name)

@section('content')



{{-- Breadcrumb --}}
<div class="max-w-6xl mx-auto px-4 mt-6 text-sm text-gray-600">
    <a href="{{ route('home') }}" class="hover:underline">Home</a> >
    <a href="{{ route('shop') }}" class="hover:underline">Shop</a> >
    <span class="text-gray-900">{{ $product->name }}</span>
</div>

{{-- Product Section --}}
<div class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 gap-10">

    {{-- Gallery --}}
    <div class="flex gap-6">
        {{-- Thumbnails --}}
        <div class="flex flex-col gap-3 w-20 overflow-y-auto">
            @foreach ($product->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}"
                     onclick="document.getElementById('main-image').src=this.src"
                     class="rounded border cursor-pointer hover:ring-2 ring-black transition object-cover h-20 w-20">
            @endforeach
        </div>

        {{-- Main Image --}}
        <div class="flex-1 border rounded aspect-[4/5] overflow-hidden">
            <img id="main-image"
                 src="{{ asset('storage/' . ($product->coverImage->image_path ?? $product->images->first()->image_path ?? 'placeholder.jpg')) }}"
                 class="w-full h-full object-cover object-center transition">
        </div>
    </div>

    {{-- Info --}}
    <div class="space-y-4">
        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
        <p class="text-sm text-gray-600">Category: {{ $product->category->name ?? '-' }}</p>

        {{-- Price --}}
        <div>
            @if ($product->sale_price)
                <span class="text-xl font-semibold text-red-600">LKR {{ number_format($product->sale_price, 2) }}</span>
                <span class="line-through text-gray-400 ml-2">LKR {{ number_format($product->price, 2) }}</span>
            @else
                <span class="text-xl font-semibold text-gray-900">LKR {{ number_format($product->price, 2) }}</span>
            @endif
        </div>

        {{-- Description --}}
        <p class="text-sm text-gray-700">{{ $product->description }}</p>

        {{-- Sizes --}}
                @if ($product->sizes)
                    <div>
                        <h4 class="text-sm font-semibold mb-1">Choose Size:</h4>
                        <div id="size-options" class="flex gap-2 flex-wrap">
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
                    <div>
                        <h4 class="text-sm font-semibold mb-1">Choose Variant:</h4>
                        <div id="variant-options" class="flex gap-2 flex-wrap">
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

        
         {{-- Wishlist Favorite Button --}}
        @php
            $isFavorited = auth()->user()->wishlist->contains($product->id);
        @endphp

        <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-12 h-10 border rounded flex items-center justify-center ml-2 transition hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $isFavorited ? 'red' : 'none' }}"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-6 h-6 {{ $isFavorited ? 'text-red-600' : 'text-gray-500' }}">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 6.707c0 4.266-6.285 8.584-9.064 10.648a1.13 1.13 0 01-1.376 0C8.285 15.291 2 10.973 2 6.707 2 4.237 4.19 2 6.64 2c1.586 0 3.018.861 3.86 2.17A4.28 4.28 0 0114.36 2c2.45 0 4.64 2.237 4.64 4.707z" />
                </svg>
            </button>
        </form>

                {{-- Add to Cart --}}
        <form action="{{ route('cart.add', $product->id) }}" method="POST" onsubmit="return validateCartSelection()" class="flex-1">
            @csrf
            <input type="hidden" name="size" id="selected-size">
            <input type="hidden" name="variant" id="selected-variant">
            <button type="submit"
                    class="w-full bg-black text-white py-2 rounded hover:bg-gray-800 transition text-sm">
                Add to Cart
            </button>
        </form>

       

    </div>
</div>

{{-- Related Products --}}
@if ($relatedProducts->count())
    <div class="max-w-6xl mx-auto px-4 pb-16">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">You may also like</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            @foreach ($relatedProducts as $related)
                <a href="{{ route('shop.show', $related->id) }}" class="block group">
                    <div class="aspect-[4/5] bg-gray-100 rounded overflow-hidden">
                        <img src="{{ asset('storage/' . ($related->coverImage->image_path ?? $related->images->first()->image_path ?? 'placeholder.jpg')) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    <h3 class="mt-2 text-sm text-gray-700 truncate">{{ $related->name }}</h3>
                    <p class="text-sm font-semibold text-gray-900">LKR {{ number_format($related->sale_price ?? $related->price, 2) }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endif

{{-- JS --}}
<script>
        function selectOption(type, value, element) {
        document.querySelectorAll(`#${type}-options button`).forEach(btn => {
            btn.classList.remove('bg-black', 'text-white');
            btn.classList.add('bg-white', 'text-gray-700');
        });
        element.classList.remove('bg-white', 'text-gray-700');
        element.classList.add('bg-black', 'text-white');
        document.getElementById(`selected-${type}`).value = value;
    }

    function validateCartSelection() {
        const size = document.getElementById('selected-size')?.value;
        const variant = document.getElementById('selected-variant')?.value;
        const variantExists = document.getElementById('variant-options') !== null;

        if (!size || (variantExists && !variant)) {
            alert('Please select all required options before adding to cart.');
            return false;
        }
        return true;
    }
</script>

@endsection
