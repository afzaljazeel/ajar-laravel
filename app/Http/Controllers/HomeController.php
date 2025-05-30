<?php

namespace App\Http\Controllers;
use App\Models\Product;


use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $topPicks = Product::with('images')->latest()->take(4)->get();
        $testimonials = [
            (object)[
                'name' => 'Sara',
                'location' => 'Dubai, UAE',
                'avatar' => asset('images/testimonials/user1.jpg'),
                'message' => 'I absolutely love the shoes I got from AJAR!'
            ],
            (object)[
                'name' => 'Omar',
                'location' => 'Colombo, LK',
                'avatar' => asset('images/testimonials/user2.jpg'),
                'message' => 'The perfumes are premium and last all day!'
            ]
        ];

        return view('home', compact('topPicks', 'testimonials'));
    }

}
