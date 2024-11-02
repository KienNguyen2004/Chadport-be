<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Group admin routes
Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => ['auth:api', 'check.user.role']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/register', [AuthController::class, 'register']);
    });
});

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
Route::post('add/products', [ProductController::class, 'createProducts'])->name('products.index');

// Category routes
Route::post('categories', [CategoryController::class, 'creates'])->name('categories.creates');
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('categories', [CategoryController::class, 'GetAll'])->name('categories.GetAll');
Route::put('categories/{id}', [CategoryController::class, 'updates'])->name('categories.updates');
Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');