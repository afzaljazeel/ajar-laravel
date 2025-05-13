<?php

use Illuminate\Support\Facades\Route;

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Middleware\AdminMiddleware;

// Public
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;

// ----------------------
// Public Routes
// ----------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'shopIndex'])->name('shop');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/contact', [MessageController::class, 'store'])->name('contact.send');

// ----------------------
// Authenticated User Routes
// ----------------------
Route::middleware(['auth'])->group(function () {

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders/place', [OrderController::class, 'store'])->name('orders.place');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // ----------------------
    // Admin Routes
    // ----------------------
    Route::middleware([AdminMiddleware::class])
        ->prefix('admin')
        ->group(function () {

            // Admin Dashboard
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

            // Product CRUD
            Route::resource('products', AdminProductController::class)->names([
                'index'   => 'admin.products.index',
                'create'  => 'admin.products.create',
                'store'   => 'admin.products.store',
                'edit'    => 'admin.products.edit',
                'update'  => 'admin.products.update',
                'destroy' => 'admin.products.destroy',
            ]);

            // Product image & status management
            Route::delete('/products/image/{id}', [AdminProductController::class, 'deleteImage'])->name('admin.products.image.delete');
            Route::patch('/products/{id}/toggle', [AdminProductController::class, 'toggleStatus'])->name('admin.products.toggle');
        });
});
