@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Products</h1>
    <a href="{{ route('admin.products.create') }}"
       class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-black">
        + Add Product
    </a>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-x-auto">
    <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 border-b text-gray-700">
            <tr>
                <th class="px-6 py-3">Image</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Category</th>
                <th class="px-6 py-3">Price</th>
                <th class="px-6 py-3">Sale Price</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>
        
        <tbody>
            @forelse ($products as $product)
            <tr class="border-b hover:bg-gray-50">
                {{-- Image Preview --}}
                <td class="px-6 py-4">
                    @if ($product->images->first())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                            class="h-16 w-16 object-cover rounded border" alt="{{ $product->name }}">
                    @else
                        <div class="h-16 w-16 flex items-center justify-center bg-gray-100 text-gray-400 rounded border">
                            No Image
                        </div>
                    @endif
                </td>

                {{-- Product Name --}}
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $product->name }}</td>

                {{-- Category --}}
                <td class="px-6 py-4 text-gray-600">{{ $product->category->name ?? '-' }}</td>

                {{-- Price --}}
                <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>

                {{-- Sale Price --}}
                <td class="px-6 py-4">
                    @if ($product->sale_price)
                        ${{ number_format($product->sale_price, 2) }}
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </td>

                {{-- Status --}}
                <td class="px-6 py-4">
                    @if ($product->status)
                        <span class="text-green-600 font-medium">Visible</span>
                    @else
                        <span class="text-gray-500 italic">Hidden</span>
                    @endif
                </td>

                {{-- Actions --}}
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                    class="inline-block bg-gray-800 text-white px-3 py-1 rounded text-xs hover:bg-black">
                        Edit
                    </a>

                    <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="text-xs px-2 py-1 rounded border text-gray-700 hover:bg-gray-200">
                            {{ $product->status ? 'Hide' : 'Show' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                        method="POST" class="inline-block"
                        onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No products available.</td>
            </tr>
            @endforelse
        </tbody>

    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
