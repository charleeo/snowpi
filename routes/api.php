<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantMenucontroller;
use App\Http\Controllers\RestruantOperatorController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;

Route::prefix('setup')->group(function(){
    Route::get('/',[SetupController::class,'setupSite']);
});

Route::prefix('users')->group(function(){

  Route::post('create', [RegisterController::class,'registerUser']);
  Route::post('login', [LoginController::class,'login']);
  Route::get('profile',[ProfileController::class,'getUserDetails']);
  Route::post('/',[ProfileController::class,'index']);
  Route::get('/{id}',[ProfileController::class,'show']);
});

// Route::group(['middleware'=>'auth:sanctum'], function(){
//     Route::post('logout', [RegisterController::class,'logout']);
//     Route::get('auth-user', [RegisterController::class,'authUser']);
// });

Route::prefix('admin')->group(function(){
    Route::post('/',[AdminController::class,'createAdminUser']);
    Route::post('/login',[AdminController::class,'adminLogin']);
});

Route::group(['middleware'=>'auth:adminapi'],function(){
    Route::get('/admin',[AdminController::class,'authAdmin']);
});


Route::prefix('restaurant')->group(function(){
  Route::post('/',[RestruantOperatorController::class,'store']);
  Route::post('/login',[RestruantOperatorController::class,'login']);
  Route::post('/index',[RestaurantController::class,'index']);
  Route::get('{id}/show',[RestaurantController::class,'show']);
  Route::group(['middleware'=>'auth:restaurant_operator_api'],function(){
    Route::get('/',[RestruantOperatorController::class,'getOperator']);
    Route::post('store',[RestaurantController::class,'create']);
    Route::post('update',[RestaurantController::class,'update']);
    Route::delete('{restaurant_guid}/delete',[RestaurantController::class,'delete']);
    //menus
    Route::post('create-menus',[RestaurantMenucontroller::class,'store']);
    Route::post('update-menus',[RestaurantMenucontroller::class,'update']);
  });
});



