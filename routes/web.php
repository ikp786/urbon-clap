<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BannerMultipleController;
use App\Http\Controllers\Admin\BannerSingleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



// Route::group(['prefix'=>"admin",'as' => 'admin.','namespace' => 'App\Http\Controllers\Admin','middleware' => ['auth','AdminPanelAccess']], function () {
Route::group(['prefix' => 'admin','middleware' => ['auth','AdminPanelAccess']], function () {
    // Route Dashboard
    Route::get('/', [HomeController::class,'index'])->name('home');
    // Route Users
    Route::resource('users', UserController::class);
    Route::post('user/change-status',[TechnicianController::class,'chageStatus'])->name('users.change-status');
    Route::group(['prefix'=>"user"], function () {
        Route::get('trash', [UserController::class,'trash'])->name('users.trash');
        Route::get('restore/{id}', [UserController::class,'restore'])->name('users.restore');
        Route::delete('delete{id}', [UserController::class,'delete'])->name('users.delete');
    });

    // Route Technician
    Route::resource('technicians', TechnicianController::class);
    Route::post('technician/change-status',[TechnicianController::class,'chageStatus'])->name('technician.change-status');
    Route::group(['prefix'=>"technician"], function () {
        Route::get('trash', [TechnicianController::class,'trash'])->name('technicians.trash');
        Route::get('restore/{id}', [TechnicianController::class,'restore'])->name('technicians.restore');
        Route::delete('delete{id}', [TechnicianController::class,'delete'])->name('technicians.delete');
    });

    // Route Roles
    Route::resource('/roles', RoleController::class);
    // Route Permission
    Route::resource('/permissions', PermissionController::class)->except(['show']);

    // Route Category
    Route::resource('categories', CategoryController::class);
    Route::post('category/change-status',[CategoryController::class,'chageStatus'])->name('category.change-status');
    Route::group(['prefix'=>"category"], function () {
        Route::get('trash', [CategoryController::class,'trash'])->name('categories.trash');
        Route::get('restore/{id}', [CategoryController::class,'restore'])->name('categories.restore');
        Route::delete('delete{id}', [CategoryController::class,'delete'])->name('categories.delete');
    });    
// Route Service   
    Route::resource('services', ServiceController::class);
    Route::post('services/change-status',[ServiceController::class,'chageStatus'])->name('services.change-status');
    Route::group(['prefix'=>"service"], function () {
        Route::get('trash', [ServiceController::class,'trash'])->name('services.trash');
        Route::get('restore/{id}', [ServiceController::class,'restore'])->name('services.restore');
        Route::delete('delete{id}', [ServiceController::class,'delete'])->name('services.delete');
    });
    // Route Time Slot
    Route::resource('timeslots', TimeSlotController::class);
    Route::post('timeslot/change-status',[TimeSlotController::class,'chageStatus'])->name('timeslots.change-status');
    Route::group(['prefix'=>"timeslot"], function () {
        Route::get('trash', [TimeSlotController::class,'trash'])->name('timeslots.trash');
        Route::get('restore/{id}', [TimeSlotController::class,'restore'])->name('timeslots.restore');
        Route::delete('delete{id}', [TimeSlotController::class,'delete'])->name('timeslots.delete');
    });

    Route::group(['prefix' => 'orders'],function(){
        Route::get('index',[OrderController::class,'index'])->name('orders.index');
        Route::post('assign-order',[OrderController::class,'assignOrder'])->name('orders.assign-order');
        Route::post('change-status',[OrderController::class,'chageStatus'])->name('order.change-status');
        Route::post('fetch-technicians-by-category',[OrderController::class,'fetchTechniciansByCategory'])->name('order.fetch-technicians-by-category');
        Route::post('admin-payment-received-status',[OrderController::class,'adminPaymentReceivedStatus'])->name('order.admin-payment-received-status');
        Route::get('detail/{id}',[OrderController::class,'detail'])->name('admin.orders.detail');
    });


    // Route Multiple Banners
    Route::resource('banner-multiples', BannerMultipleController::class);
    Route::post('banner-multiple/change-status',[BannerMultipleController::class,'chageStatus'])->name('banner-multiple.change-status');
    Route::group(['prefix'=>"banner-multiple"], function () {
        Route::get('trash', [BannerMultipleController::class,'trash'])->name('banner-multiples.trash');
        Route::get('restore/{id}', [BannerMultipleController::class,'restore'])->name('banner-multiples.restore');
        Route::delete('delete{id}', [BannerMultipleController::class,'delete'])->name('banner-multiples.delete');
    });


    // Route Single Banners
    Route::resource('banner-singles', BannerSingleController::class);
    Route::post('banner-single/change-status',[BannerSingleController::class,'chageStatus'])->name('banner-single.change-status');   
    
});