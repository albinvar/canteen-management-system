<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
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

    //create a resource for products
    Route::group(['as' => 'admin.', 'middleware' => 'auth:sanctum'], static function () {
        Route::apiResource('products', ProductController::class)->names('products')->only('index', 'show', 'store', 'update', 'destroy');
    });
});
