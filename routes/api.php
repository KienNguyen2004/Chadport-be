<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    Route::group(['middleware' => ['auth:api', 'check.user.role']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/register', [AuthController::class, 'register']);
    });
});
<<<<<<< HEAD
Route::post('categories', [CategoryController::class, 'creates'])->name('categories.creates');
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('categories', [CategoryController::class, 'GetAll'])->name('categories.GetAll');
Route::put('categories/{id}', [CategoryController::class, 'updates'])->name('categories.updates');
Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
// Route::post('products', [ProductController::class, 'create'])->name('products.index');
// Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
// Route::post('products', [ProductController::class, 'store'])->name('products.store');
// Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
=======

// Group user routes
Route::group(['prefix' => 'user'], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/activate-account/{user_id}/{token}', [UserController::class, 'activateAccount'])->name('activate-account');
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/refresh', [UserController::class, 'refresh']);
        Route::post('/update', [UserController::class, 'update']); 
    });
});

// Product routes
Route::post('products', [ProductController::class, 'create'])->name('products.index');

// Category routes
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
>>>>>>> 7ae9200d15e28a46f612b981781dbce6d279325f
