<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    // Show all wishlist items
    public function index()
    {
        $wishlistItems = Auth::user()->wishlist()->with('images')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    // Toggle add/remove product from wishlist
    public function toggle(Product $product)
    {
        $user = Auth::user();

        if ($user->wishlist()->where('product_id', $product->id)->exists()) {
            $user->wishlist()->detach($product->id);
            return back()->with('success', 'Removed from favorites.');
        } else {
            $user->wishlist()->attach($product->id);
            return back()->with('success', 'Added to favorites.');
        }
    }
}
