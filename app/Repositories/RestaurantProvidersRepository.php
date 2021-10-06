<?php

namespace App\Repositories;

use App\Exceptions\Helpers\Helper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreRestaurantOperatorRequest;
use App\Models\RestaurantOperator;
use App\Models\RestaurantRole;
use Illuminate\Http\Request;
use App\Services\AppUtils;
use App\Services\LogUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class RestaurantProvidersRepository {
   
    public function store(StoreRestaurantOperatorRequest $request)
    {
      $operator = null;
      $status ='error';
      $responseData = null;
      $error = null;
      $message ='';
      
      $data = $request->validated();
      
      if($request->operator_type  == 'owner'){          
          $data['role_id']= RestaurantRole::where(['name'=>RestaurantRole::Roles['super_admin']])->first()->id;
        }else{
            $request->validate(['role_id'=>['required','exists:restaurant_roles,id']]);
            $data = $request->validated();
      }
      try{
          $data['password']= Hash::make($data['password']);
          $operator = RestaurantOperator::create($data);
          if($operator){
              $message="Restaurant operator created";
              $status='success';
              $responseData = $operator;
          }else{
              $message= "count not create an operator";
          }


      }catch(Throwable $ex){
          $message = 'There was an error';
          $error = LogUtils::errorLog($ex);
      }
      $res = AppUtils::formatJson($message, $status, $responseData,201);
     Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Create Restaurants Operator'));
      return $res;
    }
    public function login(LoginRequest $request)
    {
      $status ='error';
      $responseData = null;
      $error = null;
      $message ='';
      $data = $request->validated();
    
      try{
         $user= RestaurantOperator::where(['email'=>$request['email']])->first();  
          if(Hash::check($data['password'], $user->password)){
              $message="Login Success";
              $status='success';
              $token = $user->createToken(config('const.token'));
              if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
              $responseData = $token->accessToken;
          }else{
              $message= "Invalid credential provided";
          }

      }catch(Throwable $ex){
          $message = 'There was an error';
          $error = LogUtils::errorLog($ex);
      }
       $res = AppUtils::formatJson($message, $status, $responseData);
       Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Restaurants Operator Login'));
       return $res;
    }

    public function getRestaurantOperator(Request $request){
        $operator = null;
        $status ='error';
        $responseData = null;
        $error = null;
        $message ='';
        try{
            $operator = Auth::guard('restaurant_operator_api')->user();
            if($operator){
                $message="User Found";
                $responseData = $operator;
                unset($responseData['password']);
                $status='success';
            }else{
                $message= "Invalid credential provided";
            }
  
        }catch(Throwable $ex){
            $message = 'There was an error';
            $error = LogUtils::errorLog($ex);
        }
         $res = AppUtils::formatJson($message, $status, $responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Restaurants Operator Login'));
         return $res;
        
    }

    public function update()
    {
        
    }

    public function delete()
    {
        
    }

}