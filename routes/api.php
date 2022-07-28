<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantMenucontroller;
use App\Http\Controllers\RestruantOperatorController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StuckCategoryController;
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


Route::prefix('category')->group(function(){
  Route::post('create',[CategoryController::class,'store']);
  Route::post('lists',[CategoryController::class,'index']);
  Route::post('sub-create',[CategoryController::class,'storeSubCategory']);
  Route::post('sub-lists',[CategoryController::class,'getSubCategory']);
  Route::post('stuck/all',[StuckCategoryController::class,'getallCategory']);
  Route::post('stuck/save',[StuckCategoryController::class,'createAcategory']);
});

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

Route::prefix('posts')->group(function(){
  Route::post('/all',[PostController::class,'index']);
  Route::get('/{id}',[PostController::class,'show']);
  // Route::group(['middleware'=> 'auth:api'],function(){
    Route::post('/',[PostController::class,'store']);
    Route::post('/update',[PostController::class,'update']);
    Route::post('/{id}',[PostController::class,'delete']);
  // });
});


Route::group(["prefix" => "stock", "middleware" => ['auth:api']], function(){
    Route::post('create', [StockController::class,"createAstockRecord"]);
});


