<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\TimeSlotController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// User Register Route
Route::post('user-register', [RegisterController::class, 'userRegister']);
Route::post('user-login', [RegisterController::class, 'userLogin']);  
Route::get('login', [RegisterController::class, 'login'])->name('login');

// Route Category
Route::get('get-all-category', [CategoryController::class, 'getAllCategory'])->name('get-all-category');
// Route Service
Route::get('get-service-by-category/{id}', [ServiceController::class, 'getServiceByCategory'])->name('get-service-by-category');
Route::get('get-service-detail/{id}', [ServiceController::class, 'getServiceDetail'])->name('get-service-detail');

// Route Authenticate
Route::group(['middleware' => ['auth:api']], function(){ 
    Route::get('/user', function (Request $request){
        return $request->user();
    });
    // Route User
    Route::get('user_profile', [UserController::class, 'userProfile']);
    Route::get('user/order-history', [UserController::class, 'userOrderHistory']);
    // Route Time Slot 
    Route::get('get-all-slot', [TimeSlotController::class, 'getAllTimeSlot'])->name('get-all-slot');
    Route::post('change-password', [UserController::class,'changePassword']);

    // Route Cart
    Route::group(['prefix'=>"carts"], function () {
        Route::post('store', [CartController::class, 'store'])->name('store');
        Route::get('get-data',[CartController::class, 'index'])->name('get-data');
        Route::post('update/{id}', [CartController::class, 'update'])->name('update');
        Route::get('delete/{id}', [CartController::class, 'destroy'])->name('delete');
    });

    // Route Order
    Route::group(['prefix'=>"order"], function () {
        Route::post('store', [OrderController::class, 'store'])->name('store');
        Route::get('user-order-history',[OrderController::class, 'userOrderHistory'])->name('user-order-history');

        Route::get('user-order-detail/{order_id}',[OrderController::class, 'userOrderDetail'])->name('user-order-detail');

    });
});
