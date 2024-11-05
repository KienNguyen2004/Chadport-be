<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Group admin routes
Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => ['auth:api', 'check.user.role']], function () { // role_id 1 2 3 
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/register', [AuthController::class, 'register']);


        Route::group(['prefix' => 'product'], function () {
            Route::get('/index', [ProductController::class, 'index']);
        });
    });
});

// Group user routes
Route::group(['prefix' => 'user'], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/activate-account/{user_id}/{token}', [UserController::class, 'activateAccount'])->name('activate-account');
    Route::group(['middleware' => ['api', 'auth:api']], function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/refresh', [UserController::class, 'refresh']);
        Route::post('/update', [UserController::class, 'update']); 
        Route::post('/add_to_cart', [CartController::class, 'add_to_cart']);
        Route::get('/cart', [CartController::class, 'get_cart']);
        Route::post('/delete_product_cart', [CartController::class, 'deleteProductCart']);
        Route::post('/update_quatity_cart', [CartController::class, 'updateQuantityCart']);
        Route::post('/payment', [CartController::class, 'payment']);
        Route::post('/add-coupon-cart', [CartController::class, 'addCouponCart']);
        Route::post('/payment', [CartController::class, 'payment']);
        Route::post('/remove-voucher', [CartController::class, 'removeVoucher']);
    });
});

// Product routes
Route::post('products', [ProductController::class, 'create'])->name('products.index');

// Category routes
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
