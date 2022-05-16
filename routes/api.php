<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\DateBasedProductController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['as' => 'api.'], static function () {

    //Basic Auth Routes
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');


    Route::group(['middleware' => 'auth:sanctum'], static function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('user', [AuthController::class, 'show'])->name('user');

        Route::apiResource('categories', CategoryController::class)->names('categories')->only(['index', 'show', 'store', 'update', 'destroy']);
    });

    //create a resource for categories
    Route::apiResource('categories', CategoryController::class)->names('categories')->only('index', 'show');
    Route::get('categories/{category:slug}/products', [CategoryController::class, 'products'])->name('categories.products');

    //date-based products
    Route::get('products/today', [DateBasedProductController::class, 'getTodaysMenu'])->name('products.today');
    Route::get('products/{date}', [DateBasedProductController::class, 'getMenuWithDate'])->name('products.date');
    Route::post('products/create', [DateBasedProductController::class, 'store'])->name('products.date.store');
    Route::put('products/{dateBasedProduct}', [DateBasedProductController::class, 'update'])->name('products.date.update');
    Route::delete('products/{dateBasedProduct}', [DateBasedProductController::class, 'destroy'])->name('products.date.destroy');

    //cart endpoints.
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/', [CartController::class, 'store'])->name('cart.store');
    Route::delete('cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('cart/{cart}', [CartController::class, 'update'])->name('cart.update');

    Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    //Route::get('wallet', [WalletController::class, 'main'])->name('wallet');
    Route::post('wallet', [WalletController::class, 'recharge'])->name('wallet.add');

    //create a resource for products
    Route::group(['as' => 'admin.', 'middleware' => 'auth:sanctum'], static function () {
        Route::apiResource('products', ProductController::class)->names('products')->only('index', 'show', 'store', 'update', 'destroy');
    });
});
