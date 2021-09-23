<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthRegisterController;
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

Route::post('users', [RegisterController::class,'registerUser']);
Route::post('login', [RegisterController::class,'login']);

Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::post('logout', [RegisterController::class,'logout']);
    Route::get('auth-user', [RegisterController::class,'authUser']);
});

Route::prefix('admin')->group(function(){
    Route::post('/',[AdminController::class,'createAdminUser']);
    Route::post('/login',[AdminController::class,'adminLogin']);
});

Route::group(['middleware'=>'auth:adminapi'],function(){
    Route::get('/admin',[AdminController::class,'authAdmin']);
});


