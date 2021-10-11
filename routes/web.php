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

    // Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class)->except(['show']);
    // Route::resource('/products', 'ProductController');

    // Route Category

    // Route::group(['prefix'=>"categories"], function () {
    Route::resource('categories', CategoryController::class);
    // Route::post('store', [CategoryController::class,'store'])->name('categories.store');
    // Route::put('update/{id}', [CategoryController::class,'update'])->name('categories.update');
    // Route::get('edit/{id}', [CategoryController::class,'edit'])->name('categories.edit');
    // Route::get('categories/list', [CategoryController::class,'list'])->name('categories.list');
    // Route::delete('destroy{id}', [CategoryController::class,'destroy'])->name('categories.destroy');
    Route::post('category/change-status',[CategoryController::class,'chageStatus'])->name('category.change-status');
    Route::group(['prefix'=>"category"], function () {
        Route::get('trash', [CategoryController::class,'trash'])->name('categories.trash');
        Route::get('restore/{id}', [CategoryController::class,'restore'])->name('categories.restore');
        Route::delete('delete{id}', [CategoryController::class,'delete'])->name('categories.delete');
    });

    // Route Category
// Route Service
    // Route::group(['prefix'=>"services"], function () {

    Route::resource('services', ServiceController::class);
        // Route::get('create', [ServiceController::class,'create'])->name('services.create');
        // Route::post('store', [ServiceController::class,'store'])->name('services.store');

        // Route::put('update/{id}', [ServiceController::class,'update'])->name('services.update');
        // Route::get('edit/{id}', [ServiceController::class,'edit'])->name('services.edit');
        // Route::get('list', [ServiceController::class,'list'])->name('services.list');
        // Route::delete('destroy{id}', [ServiceController::class,'destroy'])->name('services.destroy');
    Route::post('services/change-status',[ServiceController::class,'chageStatus'])->name('services.change-status');
    Route::group(['prefix'=>"service"], function () {

        Route::get('trash', [ServiceController::class,'trash'])->name('services.trash');
        Route::get('restore/{id}', [ServiceController::class,'restore'])->name('services.restore');
        Route::delete('delete{id}', [ServiceController::class,'delete'])->name('services.delete');
    });

});



