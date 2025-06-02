<?php

use Illuminate\Support\Facades\Route;

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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
use App\Http\Controllers\Api\APIProductController; // API ProductController



    // ----------------------
    // Public Routes
    // ----------------------
    Route::get('/', [HomeController::class, 'index'])->name('home');
   
    Route::get('/shop', [ProductController::class, 'shopIndex'])->name('shop');
    // Product Detail

    Route::get('/shop/{id}', [ProductController::class, 'show'])->name('shop.show');
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

    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');


    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    
    //checkout
    Route::middleware('auth')->get('/checkout', [OrderController::class, 'checkout'])->name('checkout');



    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders/place', [OrderController::class, 'store'])->name('orders.place');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update/{field}', [ProfileController::class, 'updateField'])->name('profile.updateField');
    Route::middleware('auth')->get('/orders/completed', [OrderController::class, 'completed'])->name('orders.completed');
    Route::get('/orders/cancelled', [OrderController::class, 'cancelled'])->name('orders.cancelled');






    // API Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/products', [APIProductController::class, 'index']);
    });



    // ----------------------
    // Admin Routes
    // ----------------------

    Route::middleware(['auth', AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Admin Dashboard
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            // Admin Profile 
            Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

            // Product CRUD
            Route::resource('products', AdminProductController::class)->names([
                'index'   => 'products.index',
                'create'  => 'products.create',
                'store'   => 'products.store',
                'edit'    => 'products.edit',
                'update'  => 'products.update',
                'destroy' => 'products.destroy',
            ]);

            // Product image & status
            Route::delete('/products/image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.image.delete');
            Route::patch('/products/{id}/toggle', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');

            //user management
            Route::resource('users', AdminUserController::class)->names([
                'index'   => 'users.index',
                'create'  => 'users.create',
                'store'   => 'users.store',
                'edit'    => 'users.edit',
                'update'  => 'users.update',
                'destroy' => 'users.destroy',
            ]);


        //orders
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
        Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');

        // Admin Completed & Cancelled Orders
        Route::get('/orders/successful', [AdminController::class, 'successfulOrders'])->name('orders.successful');
        Route::get('/orders/cancelled', [AdminController::class, 'cancelledOrders'])->name('orders.cancelled');
        Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');



        });


});
