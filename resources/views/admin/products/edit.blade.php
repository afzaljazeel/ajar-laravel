@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-sm">
    <h2 class="text-xl font-bold mb-6">Edit Product</h2>

    <!-- Main form begins -->
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->parent->name }} → {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Price + Sale Price -->
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sale Price</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <!-- Sizes -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Sizes</label>
            <input type="text" name="sizes" value="{{ old('sizes', $product->sizes ? implode(',', $product->sizes) : '') }}" class="w-full border rounded px-3 py-2" placeholder="S,M,L,40,42">
        </div>

        <!-- Variants -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Variants</label>
            <input type="text" name="variants" value="{{ old('variants', $product->variants ? implode(',', $product->variants) : '') }}" class="w-full border rounded px-3 py-2" placeholder="Black,White,100ml">
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Upload More Images -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Upload More Images</label>
            <input type="file" name="images[]" multiple class="w-full">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-black">
            Update Product
        </button>
    </form>
    <!-- Main form ends -->

    <!-- Display Current Images with Delete Buttons -->
    @if ($product->images->count())
        <div class="mt-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
            <div class="flex flex-wrap gap-3">
                @foreach ($product->images as $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="h-16 w-16 object-cover rounded border" />
                        
                        <form action="{{ route('admin.products.image.delete', $image->id) }}"
                              method="POST" onsubmit="return confirm('Delete this image?')"
                              class="absolute top-0 right-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white text-xs px-1 rounded opacity-80 group-hover:opacity-100">
                                ✕
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
