<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('coverImage')->get();

        return $products->map(function ($product) {
            $imagePath = $product->coverImage?->image_path;

            // Builds the full public URL: http://localhost:8000/storage/products/filename.jpg/png
            $imageUrl = $imagePath
                ? asset('storage/' . $imagePath)
                : asset('storage/default.jpg');

            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $imageUrl,
            ];
        });
    }
}
