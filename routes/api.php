<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CungCapController;
use App\Http\Controllers\DoanhSoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Passwordcontroller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\UserController;
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

//Auth
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::get('user', [AuthController::class, 'authUser']);

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('profile', [AuthController::class, 'profile'])->middleware('role:customer');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});


//User
Route::group([
    'middleware' => 'api',
    'role' => 'admin'
], function () {

    // User
    Route::get('user', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::post('user', [UserController::class, 'store']);
    Route::post('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'destroy']);

    //Cart
    Route::get('cart', [CartController::class, 'index']);



    // Type Product
    Route::get('type-product', [TypeProductController::class, 'index']);
    Route::post('type-product', [TypeProductController::class, 'store']);
    Route::put('type-product/{id}', [TypeProductController::class, 'update']);
    Route::delete('type-product/{id}', [TypeProductController::class, 'destroy']);

    //Product
    Route::post('list-product', [ProductController::class, 'index']);
    Route::post('product', [ProductController::class, 'store']);
    Route::post('product/{id}', [ProductController::class, 'update']);
    Route::delete('product/{id}', [ProductController::class, 'destroy']);


    // Order
    Route::get('order', [OrderController::class, 'index']);
    Route::get('order/{id}', [OrderController::class, 'show']);
    Route::put('order/{id}', [OrderController::class, 'update']);
    Route::delete('order/{id}', [OrderController::class, 'destroy']);


    //Doanh so
    Route::get('doanh-so', [DoanhSoController::class, 'index']);

    // Password
    Route::post('doi-mat-khau', [Passwordcontroller::class, 'index']);
});


Route::post('list-product-user', [ProductController::class, 'indexViewUser']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::get('cart/{id}', [CartController::class, 'show']);
Route::post('cart', [CartController::class, 'store']);

// Api cung cấp ( Admin / Nhan su / Khach Hang / Chips / Mau sac /  Dung luong )

Route::group([
    'middleware' => 'api',
    'role' => 'admin'
], function () {
    Route::get('user/customers/all', [CungCapController::class, 'customersAll']);
    Route::get('user/nhan-su/all', [CungCapController::class, 'nhanSuAll']);

    Route::get('list-dung-luongs', [CungCapController::class, 'dungLuongs']);
    Route::post('list-chips', [CungCapController::class, 'chips']);
    Route::post('list-mau-sacs', [CungCapController::class, 'mauSacs']);
});
