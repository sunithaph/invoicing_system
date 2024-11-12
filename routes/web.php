<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;


Route::get('/', [RegisterController::class, 'showRegistrationForm']);

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    // Admin-only Routes (protected with 'admin' middleware)
    Route::middleware(['admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class)->only(['create', 'store', 'destroy']);
    });
    
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'show']);    
    Route::resource('cart-items', CartItemController::class)->only(['index','create', 'store', 'update', 'destroy', 'edit']);
    Route::resource('invoices', InvoiceController::class)->only(['index', 'create', 'store', 'show']);

});
