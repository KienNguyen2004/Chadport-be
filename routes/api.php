<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Admin\ProductControllerAD;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VariantController;
use App\Http\Controllers\Api\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductControllers;
use App\Http\Controllers\CommentsController;

// Group admin routes
Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => ['auth:api', 'check.user.role']], function () { // role_id 1 2 3 
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/register', [AuthController::class, 'register']);


        Route::group(['prefix' => 'product'], function () {
            Route::get('/index', [ProductControllerAD::class, 'index']);
        });
    });
});

// Group user routes
Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/getall', [UserController::class, 'GetAllUser']);
    Route::patch('/status/{id}', [UserController::class, 'toggleUserStatus']);
    Route::get('/profile', [UserController::class, 'getProfile'])->middleware(['jwt.cookie', 'auth:api']);
    Route::get('/activate-account/{user_id}/{token}', [UserController::class, 'activateAccount'])->name('activate-account');
    Route::group(['middleware' => ['api', 'auth:api']], function () {
        Route::post('/update', [UserController::class, 'update']); 
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/refresh', [UserController::class, 'refresh']);
        Route::post('/add_to_cart', [CartController::class, 'addToCart']);
        Route::get('/cart', [CartController::class, 'get_cart']);
        Route::get('/cartbyiduser', [CartController::class, 'getCartByUserId']);
        Route::post('/delete_product_cart', [CartController::class, 'deleteProductCart']);
        Route::post('/update_quatity_cart', [CartController::class, 'updateQuantityCart']);
        Route::post('/payment', [CartController::class, 'payment']);
        Route::post('/add-coupon-cart', [CartController::class, 'addCouponCart']);
        Route::post('/payment', [CartController::class, 'payment']);
        Route::post('/remove-voucher', [CartController::class, 'removeVoucher']);
    }); 
});

// Product routes
Route::post('add/products', [ProductControllers::class, 'createProducts']);
Route::get('list/products', [ProductControllers::class, 'showProduct']);
Route::get('shop/products', [ProductControllers::class, 'showShopProducts']);
Route::get('showdetail/products/{id}', [ProductControllers::class, 'showDetail']);
Route::delete('delete/products/{id}', [ProductControllers::class, 'destroy']);
Route::post('update/products/{id}', [ProductControllers::class, 'updateProduct']);
Route::get('/products/category/{cat_id}', [ProductControllers::class, 'getProductsByCategory']);

// Category routes
Route::post('categories', [CategoryController::class, 'create'])->name('categories.creates');
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('getall/categories', [CategoryController::class, 'GetAll'])->name('categories.GetAll');
Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.updates');
Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');


// Color routes
Route::post('colors', [ColorController::class, 'createColor']); // 
Route::get('colors', [ColorController::class, 'GetAll']); // Lấy tất cả màu sắc
Route::get('colors/{id}', [ColorController::class, 'getColor']); // Lấy màu sắc theo ID
Route::put('colors/{id}', [ColorController::class, 'updates']); // Cập nhật màu sắc
Route::delete('colors/{id}', [ColorController::class, 'deleteColor']); // Xóa màu sắc

// Size routes
Route::get('/sizes', [SizeController::class, 'GetAll']);
Route::get('/sizes/{id}', [SizeController::class, 'show']);
Route::post('/sizes', [SizeController::class, 'creates']); // Đảm bảo có dòng này
Route::put('/sizes/{id}', [SizeController::class, 'updates']);
Route::delete('/sizes/{id}', [SizeController::class, 'destroy']);


// Variant routes
Route::post('products/{productId}/variants', [VariantController::class, 'creates']); // Route để tạo mới variant
Route::get('productsvariants/{id}', [VariantController::class, 'show']);
Route::get('products/{productId}/variants', [VariantController::class, 'GetAll']); // Route để lấy tất cả variants
Route::put('variants/{id}', [VariantController::class, 'updates']); // Route để cập nhật variant
Route::delete('variants/{id}', [VariantController::class, 'destroy']); // Route để xóa variant


// Brand route
Route::resource('brand', BrandController::class);

//Voucher route
Route::resource('voucher', VoucherController::class);

// comments routes
Route::post('add/comments', [CommentsController::class, 'createComments']);
Route::get('getall/comments/{product_id}', [CommentsController::class, 'getCommentsByProduct']);
Route::delete('delete/comments/{comment_id}', [CommentsController::class, 'deleteComment']);

