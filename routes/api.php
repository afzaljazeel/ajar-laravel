<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CategoryController;
use App\Models\User;

// 🔓 Public API Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// 🔓 Register
Route::post('/register', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
    ]);

    $token = $user->createToken('ajar-token')->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user], 201);
});

// 🔓 Login
Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('ajar-token')->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user], 200);
});

// 🔒 Protected API Routes (Sanctum Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());

    // Orders
    Route::apiResource('orders', OrderController::class)->only(['index', 'store']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);
});
