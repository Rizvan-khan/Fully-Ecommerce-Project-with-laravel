<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;

use App\Http\Controllers\SellerController;
use App\Http\Controllers\CartController;

// Public routes

Route::get('/',[WebController::class, 'index']);
Route::get('/index',[WebController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// cart route
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [CartController::class, 'getAllCart'])->name('cart');
Route::get('/cart-page', function () {
    return view('cart');
});
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

Route::get('/totalAmount', [CartController::class, 'totalAmount'])->name('totalAmount');
Route::get('/modaldata', [CartController::class, 'getallmodalproductwithproductid'])->name('modaldata');
Route::post('/cart/decrease', [CartController::class, 'decreaseQty']);
Route::post('/cart/increase', [CartController::class, 'increaseQty']);
// Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

Route::post('/add-to-cart', [CartController::class, 'addToWishlist'])->name('add.to.cart');
Route::get('/wishlist/count', [CartController::class, 'wishlistCount'])->name('wishlist.count');
Route::get('/wishlist',[CartController::class, 'wishlistitem'])->name('wishlist');
Route::get('/wishlistproduct', [CartController::class, 'getAllwishlistproduct'])->name('wishlistproduct');
Route::post('/wishlist/remove', [CartController::class, 'removewish'])
    ->name('wishlist.remove');







// Protected routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
     Route::get('/admin/all-user', [AdminController::class, 'alluser'])->name('admin.all-user');
      Route::get('/admin/add-user', [AdminController::class, 'user'])->name('admin.add-user');
      Route::post('/admin/add-user', [AdminController::class, 'store'])->name('admin.add-user');
        Route::get('/edit-user/{id}', [AdminController::class, 'edit'])->name('admin.user.edit-user');
    Route::post('/update-user/{id}', [AdminController::class, 'update'])->name('admin.user.update');

    // Delete user
    Route::get('/delete-user/{id}', [AdminController::class, 'destroy'])->name('user.delete');
     Route::get('/admin/product', [AdminController::class, 'product'])->name('admin.product.add-product');
     Route::get('/admin/category', [AdminController::class, 'category'])->name('admin.category.add-category');
     Route::post('/admin/category', [AdminController::class, 'add_category'])->name('admin.category');
      Route::get('/admin/manage-category', [AdminController::class, 'manage_category'])->name('admin.manage-category');
Route::get('admin/category/edit/{id}', [AdminController::class, 'edit_cat'])->name('admin.category.edit');
    Route::delete('admin/category/delete/{id}', [AdminController::class, 'destroy'])->name('admin.category.delete');
Route::put('admin/category/update/{id}', [AdminController::class, 'update_cat'])->name('admin.category.update');


// get subcat woth cat
// routes/web.php
Route::get('get-subcategories/{category_id}', [AdminController::class, 'getSubcategories']);



Route::post('admin/product/store', [AdminController::class, 'add_product'])->name('admin.product.store');
   Route::get('admin/product/edit/{id}', [AdminController::class, 'edit_product'])->name('admin.product.edit');
    Route::post('admin/product/update/{id}', [AdminController::class, 'update_product'])->name('admin.product.update');
    Route::get('admin/product/delete/{id}', [AdminController::class, 'destroy_product'])->name('admin.product.delete');
   Route::get('admin/manage-product', [AdminController::class, 'all_product'])->name('admin.manage-product');
   Route::get('admin/add-slider', [AdminController::class, 'slider'])->name('admin.add-slider');
   Route::post('admin/add-slider', [AdminController::class, 'add_slider'])->name('admin.add-slider');
   Route::get('admin/manage-slider', [AdminController::class, 'get_slider'])->name('admin.manage-slider');
Route::get('/admin/add-subcategory',[AdminController::class, 'subcat'])->name('admin.add-subcategory');
Route::post('/admin/add-subcategory',[AdminController::class, 'add_subcat'])->name('admin.add-subcategory');
Route::get('/admin/manage-logo',[AdminController::class, 'manage_logo'])->name('admin.manage-logo');
Route::get('admin/logo/update-logo/{id}', [AdminController::class, 'edit_logo'])->name('admin.logo.update-logo');
Route::put('admin/logo/update-logo/{id}', [AdminController::class, 'upload_logo'])->name('admin.logo.update-logo');



});

Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
     Route::get('/seller/product', [SellerController::class, 'product'])->name('seller.product.add-product');
    Route::get('seller/manage-product', [SellerController::class, 'all_product'])->name('seller.manage-product');
Route::post('seller/product/store', [SellerController::class, 'add_product'])->name('seller.product.store');
  Route::get('seller/product/edit/{id}', [SellerController::class, 'edit_product'])->name('seller.product.edit');
    Route::post('seller/product/update/{id}', [SellerController::class, 'update_product'])->name('seller.product.update');
    Route::get('seller/product/delete/{id}', [SellerController::class, 'destroy_product'])->name('seller.product.delete');
  

});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
     Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
     Route::post('/save-details',[CartController::class, 'saveDetails'])->name('save-details');
     Route::get('/checkout/review', [CartController::class, 'checkout_review'])->name('checkout.review');

});

