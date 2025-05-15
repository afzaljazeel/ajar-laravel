<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products
    public function index()
    {
        return response()->json(Product::with('category')->get(), 200);
    }

    // GET /products/{id}
    public function show($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);

        // Fetch related products from the same category (excluding this product)
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    // GET /shop (with optional filtering)
    public function shopIndex(Request $request)
    {
        $query = Product::with(['category', 'images'])
                        ->where('status', true);

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('shop.index', compact('products', 'categories'));
    }
}
