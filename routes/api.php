<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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
    Route::group(['middleware' => ['auth:api', 'check.user.role']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/register', [AuthController::class, 'register']);
    });
});
Route::post('products', [ProductController::class, 'create'])->name('products.index');
// Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
// Route::post('products', [ProductController::class, 'store'])->name('products.store');
// Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
