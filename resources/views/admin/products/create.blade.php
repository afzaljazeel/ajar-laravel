@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-sm">
    <h2 class="text-xl font-bold mb-6">Add New Product</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" name="name" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" class="mt-1 w-full border rounded px-3 py-2" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->parent->name }} → {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Price (LKR)</label>
            <input type="number" step="0.01" name="price" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>

            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Sale Price</label>
            <input type="number" step="0.01" name="sale_price" class="mt-1 w-full border rounded px-3 py-2">
        </div>


        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Product Images</label>
            <input type="file" name="images[]" multiple class="mt-1 w-full">
            <small class="text-gray-500">You can upload multiple images</small>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4" class="mt-1 w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Sizes (comma-separated)</label>
            <input type="text" name="sizes" class="mt-1 w-full border rounded px-3 py-2" placeholder="S,M,L or 40,41,42">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Variants (comma-separated: ml/color/etc.)</label>
            <input type="text" name="variants" class="mt-1 w-full border rounded px-3 py-2" placeholder="Black,White,100ml">
        </div>

        <button type="submit"
                class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-black">
            Add Product
        </button>
    </form>
</div>
@endsection
