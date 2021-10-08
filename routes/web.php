<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
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



Route::group(['prefix'=>"admin",'as' => 'admin.','namespace' => 'App\Http\Controllers\Admin','middleware' => ['auth','AdminPanelAccess']], function () {

    Route::get('/', [HomeController::class,'index'])->name('home');

    Route::resource('/users', 'UserController');
    Route::resource('/roles', 'RoleController');
    Route::resource('/permissions', 'PermissionController')->except(['show']);
    Route::resource('/products', 'ProductController');

    // Route Category

    Route::group(['prefix'=>"categories"], function () {
    Route::get('create', [CategoryController::class,'create'])->name('categories.create');
    Route::post('store', [CategoryController::class,'store'])->name('categories.store');
    Route::put('update/{id}', [CategoryController::class,'update'])->name('categories.update');
    Route::get('edit/{id}', [CategoryController::class,'edit'])->name('categories.edit');
    Route::get('list', [CategoryController::class,'list'])->name('categories.list');
    Route::delete('destroy{id}', [CategoryController::class,'destroy'])->name('categories.destroy');
    Route::get('trash', [CategoryController::class,'trash'])->name('categories.trash');
    Route::get('restore/{id}', [CategoryController::class,'restore'])->name('categories.restore');
    Route::delete('delete{id}', [CategoryController::class,'delete'])->name('categories.delete');
    });

    // Route Category
// dd($_SERVER);die;
    Route::group(['prefix'=>"services"], function () {
    Route::get('create', [ServiceController::class,'create'])->name('services.create');
    Route::post('store', [ServiceController::class,'store'])->name('services.store');

    Route::put('update/{id}', [ServiceController::class,'update'])->name('services.update');
    Route::get('edit/{id}', [ServiceController::class,'edit'])->name('services.edit');
    Route::get('list', [ServiceController::class,'list'])->name('services.list');
    Route::delete('destroy{id}', [ServiceController::class,'destroy'])->name('services.destroy');
    Route::get('trash', [ServiceController::class,'trash'])->name('services.trash');
    Route::get('restore/{id}', [ServiceController::class,'restore'])->name('services.restore');
    Route::delete('delete{id}', [ServiceController::class,'delete'])->name('services.delete');
    });

});



