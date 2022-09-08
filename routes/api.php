<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('setup')->group(function(){
    Route::get('/',[SetupController::class,'setupSite']);
    Route::get('/state/all',[SetupController::class,'getAllStates']);
    Route::post('/region/all',[SetupController::class,'getAllRegions']);
});

Route::prefix('users')->group(function(){

  Route::post('/create', [RegisterController::class,'registerUser']);
  Route::post('login', [LoginController::class,'login']);
  Route::get('facebook-login',[LoginController::class,'socialLogin']);
  Route::get('profile',[ProfileController::class,'getUserDetails']);
  Route::post('/',[ProfileController::class,'index']);
  Route::post('/create/user',[ProfileController::class,'createUser']);
  Route::get('/{id}',[ProfileController::class,'show']);
});


Route::group([
   "prefix"=>"warehouse",
   'middleware' => 'auth:api',
  ],function(){
  Route::post('create',[WarehouseController::class ,"createWarehouse"]);
  Route::post('get/all',[WarehouseController::class ,"index"]);
  Route::post('get/all/for_user',[WarehouseController::class ,"getWarehousesForAUser"]);

  Route::get('get/details/{id}',[WarehouseController::class ,"getAWarehouse"]);
});


Route::group(["prefix" => "stock", "middleware" => ['auth:api']], function(){
    Route::post('create', [StockController::class,"createAstockRecord"]);
});



