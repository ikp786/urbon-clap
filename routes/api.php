<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;

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

Route::group(['middleware' => ['auth:api']], function(){ 
    Route::get('/user', function (Request $request){
        return $request->user();
    });
    Route::get('user_profile', [UserController::class, 'userProfile']);

    });
