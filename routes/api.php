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
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\RattingController;
use App\Http\Controllers\ContactUsController;

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
//Route Technician Login
Route::post('technician-login', [RegisterController::class, 'technicianLogin']);
// Route Category
Route::get('get-all-category', [CategoryController::class, 'getAllCategory'])->name('get-all-category');
// Route Service
Route::get('get-service-by-category/{id}', [ServiceController::class, 'getServiceByCategory'])->name('get-service-by-category');
Route::get('get-service-detail/{id}', [ServiceController::class, 'getServiceDetail'])->name('get-service-detail');
Route::get('search-service',[ServiceController::class, 'searchService'])->name('search-service');
Route::get('fetch-single-banner',[BannerController::class,'fetchSingleBanner'])->name('fetch-single-banner');
Route::get('fetch-multiple-banner',[BannerController::class,'fetchMultipleBanner'])->name('fetch-Multiple-banner');

// Route Authenticate
Route::group(['middleware' => ['auth:api']], function(){ 

    Route::get('/user', function (Request $request){
        return $request->user();
    });
    // Route User
    Route::get('user_profile', [UserController::class, 'userProfile']);
    Route::get('user/order-history', [UserController::class, 'userOrderHistory']);
    Route::post('update-user-profile',[UserController::class,'updateUserProfile'])->name('update-user-profile');

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
    // Route Start Work
    Route::post('start-work',[OrderController::class,'startWork'])->name('start-work');
    // Route End Work
    Route::post('end-work',[OrderController::class,'endWork'])->name('end-work');
    // Route OTP verify After Complete Work
    Route::post('verify-otp-complete-work',[OrderController::class,'verifyOtpCompleteWork'])->name('verify-otp-complete-work');
    // Route Order
    Route::group(['prefix'=>"order"], function () {

        // Route User Order
        Route::post('store', [OrderController::class, 'store'])->name('store');
        Route::get('user-order-history',[OrderController::class, 'userOrderHistory'])->name('user-order-history');
        Route::get('user-order-detail/{order_id}',[OrderController::class, 'userOrderDetail'])->name('user-order-detail');
        Route::post('cancel',[OrderController::class,'cancel'])->name('order.cancel');
        // Route Technician Order
        Route::get('technician-order-history/{status?}',[OrderController::class, 'technicianOrderHistory'])->name('technician-order-history');
        Route::get('technician-order-detail/{order_id}',[OrderController::class, 'technicianOrderDetail'])->name('technician-order-detail');
        Route::post('technician-order-accept-or-decline',[OrderController::class, 'technicianOrderAcceptOrDecline'])->name('technician-order-accept-or-decline');        
    });
    // Route Technician 
    Route::get('technician-home-screen-detail',[RegisterController::class, 'technicianHomeScreenDetail'])->name('technician-home-screen-detail');  
    Route::post('change-online-status',[UserController::class,'changeOnlineStatus'])->name('change-online-status');

    // Route Ratting
    Route::post('save-ratting',[RattingController::class,'store'])->name('save-ratting');
});

// Route Contact Us
Route::post('save-contact-us',[ContactUsController::class,'store'])->name('save-contact-us');