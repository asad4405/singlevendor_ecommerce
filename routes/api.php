<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;

// =========== api ============= //
Route::get('settings',[SettingsController::class,'settings']);
Route::get('contact-info',[SettingsController::class,'contact_info']);


// products
Route::get('/front-category-products', [ProductController::class, 'frontCategoryProducts']);
Route::get('/product-details/{slug}', [ProductController::class, 'productDetails']);
Route::get('/related-products/{slug}', [ProductController::class, 'relatedProducts']);

// cart
Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::get('/cart-products', [CartController::class, 'cartProducts']);
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart']);
Route::post('/clear-cart', [CartController::class, 'clearCart']);

// orders
Route::post('/place-order', [OrderController::class, 'placeOrder']);
Route::post('/track-order', [OrderController::class, 'trackOrder']);
