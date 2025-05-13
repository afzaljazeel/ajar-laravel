<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::with(['category', 'images'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Show create product form
    public function create()
    {
        $categories = Category::whereNotNull('parent_id')->get();
        return view('admin.products.create', compact('categories'));
    }

    // Store a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'sizes' => 'nullable|string',
            'variants' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['sizes'] = $request->sizes ? explode(',', $request->sizes) : null;
        $validated['variants'] = $request->variants ? explode(',', $request->variants) : null;

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            $images = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];
            foreach ($images as $img) {
                $path = $img->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::whereNotNull('parent_id')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'sizes' => 'nullable|string',
            'variants' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['sizes'] = $request->sizes ? explode(',', $request->sizes) : null;
        $validated['variants'] = $request->variants ? explode(',', $request->variants) : null;

        $product->update($validated);

        if ($request->hasFile('images')) {
            $images = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];
            foreach ($images as $img) {
                $path = $img->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Delete a product and its images
    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    // Delete one image
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted.');
    }

    // Toggle product visibility
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = !$product->status;
        $product->save();

        return back()->with('success', 'Product visibility updated.');
    }
}
