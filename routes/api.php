<?php

use App\Http\Controllers\Api\CategoryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
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
