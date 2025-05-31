<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Testimonial;



use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
            $topPicks = Product::with(['images', 'coverImage'])->where('status', true)->inRandomOrder()->limit(8)->get();

    $testimonials = Testimonial::inRandomOrder()->get();

    return view('home', compact('topPicks', 'testimonials'));
    }

}
