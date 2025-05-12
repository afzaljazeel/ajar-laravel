@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="w-full px-6 py-10">
    <div class="flex flex-col lg:flex-row lg:items-start gap-10">

        <!-- Sidebar: Categories -->
        <aside class="w-full lg:max-w-[220px] lg:min-w-[200px]">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Categories</h2>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('shop') }}"
                       class="block px-3 py-2 rounded border border-gray-200 hover:bg-gray-300 transition
                       {{ request('category') ? 'text-gray-700' : 'bg-gray-900 text-white' }}">
                        All
                    </a>
                </li>

                @foreach ($categories as $parent)
                    <li class="font-semibold text-gray-800 mt-4">{{ $parent->name }}</li>
                    <ul class="pl-4 space-y-1 text-sm text-gray-600">
                        @foreach ($parent->children as $child)
                            <li>
                                <a href="{{ route('shop', ['category' => $child->id]) }}"
                                   class="block px-3 py-1 rounded border border-transparent hover:bg-gray-300 transition
                                   {{ request('category') == $child->id ? 'bg-gray-900 text-white' : '' }}">
                                    {{ $child->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </ul>
        </aside>

        <!-- Products Grid -->
        <section class="w-full lg:flex-[3_0_0]">
            <h1 class="text-2xl font-semibold mb-6 text-gray-900">Products</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @forelse ($products as $product)
                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            <p class="text-gray-900 font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                            <a href="{{ route('product.show', $product->id) }}"
                               class="block mt-4 text-sm text-center bg-gray-900 text-white py-2 rounded hover:bg-black transition">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">No products available.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>

@endsection
