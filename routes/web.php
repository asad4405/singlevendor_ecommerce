<?php

use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ShoppingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/',[FrontendController::class,'index'])->name('index');
Route::get('/category/product/{slug}',[FrontendController::class,'category_product'])->name('category.product');
Route::get('/subcategory/product/{slug}',[FrontendController::class,'subcategory_product'])->name('subcategory.product');

Route::get('/product/{slug}',[FrontendController::class,'product_details'])->name('product.details');
Route::get('/get-sizes-by-color', [FrontendController::class, 'getSizesByColor']);
Route::get('/get-inventory-by-size', [FrontendController::class, 'getInventoryBySize']);

Route::get('/get-sizes-by-color', [FrontendController::class, 'getSizesByColor']);
Route::get('/shop',[FrontendController::class,'shop'])->name('shop');
Route::get('/contact',[FrontendController::class,'contact'])->name('contact');
Route::post('/contact/submit',[FrontendController::class,'contact_submit'])->name('contact.submit');

Route::post('/add-to-cart',[ShoppingController::class,'add_to_cart'])->name('add-to-cart');
Route::get('/cart',[ShoppingController::class,'cart_view'])->name('cart');
Route::get('/cart/remove/{key}', [ShoppingController::class, 'cart_remove'])->name('cart.remove');

Route::get('/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');


// customer
Route::get('/customer/register', [CustomerController::class, 'register'])->name('customer.register');
Route::post('/customer/register/store', [CustomerController::class, 'register_store'])->name('customer.register.store');
Route::get('/customer/login', [CustomerController::class, 'login'])->name('customer.login');
Route::post('/customer/login/store', [CustomerController::class, 'login_store'])->name('customer.login.store');
Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
Route::post('/customer/profile/update', [CustomerController::class, 'profile_update'])->name('customer.profile.update');

// customer order
Route::post('/customer/order/save', [CustomerController::class, 'order_save'])->name('customer.ordersave');
Route::get('/order-success/{id}', [CustomerController::class, 'order_success'])->name('order.success');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__ . '/admin.php';
