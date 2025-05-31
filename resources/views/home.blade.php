@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- Hero Section --}}
<section
    class="relative bg-cover bg-center min-h-[80vh] flex items-center justify-center text-center text-white"
    style="background-image: url('{{ asset('images/hero-bg.jpg') }}'); background-position: center; background-size: cover;">
    
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/60"></div>

    {{-- Content --}}
    <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="200">
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6">
            ELEVATE THE EVERYDAY<br>FROM SOLES TO SCENTS.
        </h1>
        <a href="{{ route('shop') }}"
           class="inline-block bg-white text-black px-8 py-3 rounded-full text-sm font-semibold tracking-wide hover:bg-gray-200 transition">
            Shop Now
        </a>
    </div>
</section>

{{-- Category Cards --}}
<section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="text-2xl font-bold mb-6" data-aos="fade-up">Categories</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('shop', ['category' => 'shoes']) }}"
           class="relative overflow-hidden rounded-lg group" data-aos="fade-right" data-aos-delay="100">
            <img src="{{ asset('images/categories/shoes.jpg') }}" class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition">
            <div class="absolute bottom-0 left-0 p-6 text-white bg-gradient-to-t from-black/80 to-transparent w-full">
                <h3 class="text-xl font-bold">Top Footwear</h3>
                <p class="text-sm">Walk Proud</p>
            </div>
        </a>
        <a href="{{ route('shop', ['category' => 'perfumes']) }}"
           class="relative overflow-hidden rounded-lg group" data-aos="fade-left" data-aos-delay="200">
            <img src="{{ asset('images/categories/perfumes.jpg') }}" class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition">
            <div class="absolute bottom-0 left-0 p-6 text-white bg-gradient-to-t from-black/80 to-transparent w-full">
                <h3 class="text-xl font-bold">Signature Perfumes</h3>
                <p class="text-sm">Luxury fragrances for all</p>
            </div>
        </a>
    </div>
</section>

{{-- Featured Cards Section --}}
<section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="text-2xl font-bold mb-6" data-aos="fade-up">Top Picks for you!</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($topPicks as $index => $product)
            <a href="{{ route('product.show', $product->id) }}"
               class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition block"
               data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                <img src="{{ asset('storage/' . ($product->coverImage->image_path ?? $product->images->first()->image_path ?? 'placeholder.jpg')) }}"
                     class="w-full h-72 object-cover" alt="{{ $product->name }}">

                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600">LKR {{ number_format($product->sale_price ?? $product->price, 2) }}</p>
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- Testimonials --}}
<section class="bg-gray-100 py-16">
    <h2 class="text-2xl font-bold text-center mb-8" data-aos="fade-up">What Our Customers Say</h2>
    <div class="max-w-6xl mx-auto px-4 overflow-x-auto">
        <div class="flex gap-6">
            @foreach ($testimonials as $index => $feedback)
                <div class="min-w-[300px] bg-white rounded-lg p-4 shadow-sm"
                     data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ asset($feedback->avatar) }}" class="w-10 h-10 rounded-full object-cover border">
                        <div>
                            <p class="text-sm font-semibold">{{ $feedback->name }}</p>
                            <p class="text-xs text-gray-500">{{ $feedback->location }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm">{{ $feedback->message }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
