<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    //
    public function toggle(Product $product)
    {
        $user = Auth::user();

        if ($user->wishlist()->where('product_id', $product->id)->exists()) {
            // Remove from wishlist
            $user->wishlist()->detach($product->id);
            return back()->with('success', 'Removed from favorites.');
        } else {
            // Add to wishlist
            $user->wishlist()->attach($product->id);
            return back()->with('success', 'Added to favorites.');
        }
    }

}
