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

    // GET /api/products/{id}
    public function show($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);
        return view('shop.show', compact('product'));
    }


    // Product Filtering
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