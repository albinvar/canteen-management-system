<?php

use App\Http\Controllers\Api\AuthController;
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
    });
});
