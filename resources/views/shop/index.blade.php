@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10">
        {{-- Mobile Dropdown Button --}}
        <div class="lg:hidden mb-4">
            <button onclick="toggleSidebar()"
                    class="w-full px-4 py-2 bg-gray-800 text-white rounded hover:bg-black transition">
                Filter Categories
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            {{-- Sidebar --}}
            <aside id="categorySidebar"
                class="w-full lg:w-64 lg:block hidden lg:sticky top-24 bg-white border lg:border-0 rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Categories</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('shop') }}"
                        class="block px-3 py-2 rounded border border-gray-200 hover:bg-gray-100 transition
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
                                    class="block px-3 py-1 rounded border border-transparent hover:bg-gray-200 transition
                                            {{ request('category') == $child->id ? 'bg-gray-900 text-white' : '' }}">
                                        {{ $child->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </ul>
            </aside>

            {{-- Product Grid --}}
            <section class="flex-1">
                <h1 class="text-2xl font-semibold mb-6 text-gray-900">Products</h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @forelse ($products as $product)
                        <div class="bg-white border rounded-xl overflow-hidden shadow hover:shadow-md transition">
                            <div class="aspect-[4/3] w-full overflow-hidden">
                                <img src="{{ asset('storage/' . ($product->images->first()->image_path ?? 'placeholder.jpg')) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover object-center" />
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-800">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                @if ($product->sale_price)
                                    <p class="text-gray-900 font-bold mt-2">
                                        <span class="line-through text-gray-400 mr-2">${{ number_format($product->price, 2) }}</span>
                                        ${{ number_format($product->sale_price, 2) }}
                                    </p>
                                @else
                                    <p class="text-gray-900 font-bold mt-2">
                                        ${{ number_format($product->price, 2) }}
                                    </p>
                                @endif
                                <a href="{{ route('product.show', $product->id) }}"
                                class="block mt-4 text-sm text-center bg-gray-900 text-white py-2 rounded hover:bg-black transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-4 text-center text-gray-500">No products available.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

{{-- JavaScript to toggle sidebar on mobile --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('categorySidebar');
            sidebar.classList.toggle('hidden');
        }
    </script>
@endsection

