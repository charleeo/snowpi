<?php

namespace App\Repositories;

use App\Exceptions\Helpers\Helper;
use App\Http\Requests\DeleteRestaurantRequest;
use App\Http\Requests\StoreRestaurantRequest;
use App\Models\Restaurant;
use App\Models\RestaurantRole;
use App\Services\AppUtils;
use App\Services\LogUtils;
use App\Services\TokenMaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class RestaurantRepository {
   public function store(StoreRestaurantRequest $request, $id = null)
   {
     $status ='error';
     $responseData = null;
     $error = null;
     $message ='';
     $user  = Auth::guard('restaurant_operator_api')->user();
     $restaurant =null;
     
     try{
        $data = $request->toArray();
        if($id){
           $request->validate(['restaurant_guid' =>['required','string','exists:restaurants,restaurant_guid']]);
           $restaurant = Restaurant::where(['restaurant_guid'=>$id])->first();
           $restaurant  = $restaurant->update($data);
         }else{
            $request->merge(['restaurant_operator_id'=>$user->id]);
            $data['restaurant_guid'] = TokenMaker::makeRestaurantGUID();
            $restaurant = Restaurant::create($data);
         }
         if($restaurant){
           $message= $id? "Restaurant data updated":"Restaurant data created";
            $status = 'success';
            $responseData = $restaurant;
        }
      }catch(Throwable $ex){
        $message = 'There was an error';
        $error = LogUtils::errorLog($ex);
      }
      $res = AppUtils::formatJson($message, $status, $responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Creating Restaurants'));
         return $res;
   }

   public function index(Request $request)
   {
      $status ='error';
      $responseData = null;
      $error = null;
      $message ='';
      $query = [];
     $valid = Validator::make($request->all(),['per_page'=>['nullable','integer'],'name'=>['nullable','string'],'address_line_1'=>['nullable','string'],'address_line_2'=>['nullable','string']]);
    
     if($valid->fails()){
        return $valid->errors()->all();
     }

      try{
      $filters  = $request->validate(['name'=>'nullable|string','address_line_1'=>'nullable|string','address_line_2'=>'nullable|string']);
      
      foreach($filters as $key => $filter){
         if($filter ==null) continue;
         $query = array_merge($query,[["restaurants.$key","LIKE","%$filter%"]]);
      }
      
      $restaurants = DB::table('restaurants')
      ->leftJoin('local_governments','restaurants.town_id','=','local_governments.id')
      ->leftJoin('states','states.id','=','local_governments.state_id')
      ->leftJoin('restaurant_operators','restaurant_operators.id','=','restaurants.restaurant_operator_id')
      ->where('deleted_at','=',null)
      ->where($query)
      ->select(
         'restaurants.*',
         'states.name  as state',
         'states.id as state_id',
         'local_governments.name as town',
         'restaurant_operators.name  as operator_name',
         'restaurant_operators.email  as operator_email'
      )
      ->orderBy('created_at','DESC');
      if($request->per_page){
         $restaurants = $restaurants->paginate((int)$request->per_page);
      }else{
         $restaurants = $restaurants->get();
      }

        if(count($restaurants) >0){
           $responseData = $restaurants;
           $message = "Query OK";
         }else{
            $message = "No Record found";
         }
         $status = 'success';
      }catch(Throwable $ex){
         $message = 'There was an error';
         $error = LogUtils::errorLog($ex);
       }
       $res = AppUtils::formatJson($message, $status, $responseData);
          Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Restaurants Operator Login'));
          return $res;
   }

   public function show(Request $request,$id){
      $status ='error';
      $responseData = null;
      $error = null;
      $message ='';
      try{
      $restaurants = DB::table('restaurants')
      ->leftJoin('local_governments','restaurants.town_id','=','local_governments.id')
      ->leftJoin('states','states.id','=','local_governments.state_id')
      ->leftJoin('restaurant_operators','restaurant_operators.id','=','restaurants.restaurant_operator_id')
      ->where(['restaurant_guid'=>$id])
      ->select(
         'restaurants.*',
         'states.name  as state',
         'states.id as state_id',
         'local_governments.name as town',
         'restaurant_operators.name  as operator_name',
         'restaurant_operators.email  as operator_email'
      )->first();

        if($restaurants){
           $responseData = $restaurants;
           $message = "Query OK";
         }else{
            $message = "No Record found";
         }
         $status = 'success';
      }catch(Throwable $ex){
         $message = 'There was an error';
         $error = LogUtils::errorLog($ex);
       }
       $res = AppUtils::formatJson($message, $status, $responseData);
          Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Restaurants Operator Login'));
          return $res;
   }

   public function delete(DeleteRestaurantRequest $request,$id)
   {
      $status ='error';
      $responseData = null;
      $error = null;
      $message ='';
      try{
      $restaurant = Restaurant::where(["restaurant_guid"=>$id])->first();

        if($restaurant){
           $restaurant->delete();
           $responseData = $restaurant;
           $message = "Record  delete";
         }else{
            $message = "No Record found for to delete";
         }
         $status = 'success';
      }catch(Throwable $ex){
         $message = 'There was an error';
         $error = LogUtils::errorLog($ex);
       }
       $res = AppUtils::formatJson($message, $status, $responseData);
          Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Restaurants Operator Login'));
          return $res;
   }
}