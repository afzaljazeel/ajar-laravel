<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

use App\Models\User;

// 🔓 Public API Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// 🔒 Protected API Routes (require login & token)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('orders', OrderController::class)->only(['index', 'store']);

    // You can add more later, e.g.
    // Route::get('/cart', [CartController::class, 'index']);
});


Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('ajar-token')->plainTextToken;

    return response()->json(['token' => $token], 200);
});