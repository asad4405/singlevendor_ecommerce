<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;

// =========== api ============= //
Route::get('settings',[SettingsController::class,'settings']);
Route::get('contact-info',[SettingsController::class,'contact_info']);


// cart
Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::get('/cart-products', [CartController::class, 'cartProducts']);
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart']);
