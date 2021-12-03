<?php

namespace App\Http\Controllers;

use App\Exceptions\Helpers\Helper;
use App\Models\User;
use App\Services\AppUtils;
use App\Services\LogUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ProfileController extends Controller
{
    public function __construct($id =null)
    {   if(!$id){
            return $this->middleware(['auth:api'])->except(['index','show']);
        }
    }
    public function getUserDetails(Request $request)
    {  
       $responseMessage = '';
       $status = false;
       $responseData = null;
       $error = null;
       $user = null;
       try{
        if(Auth::check()){
            $user = User::find(auth()->id());
            if($request->is_user_id_provided !==false && $request->user_id !==null){
                $user = User::find($request->user_id);
           }
        }elseif(!Auth::check() && $request->is_user_id_provided ==true && $request->user_id !==null){
          $user = User::find($request->user_id);
        }
        if($user){
          $responseData = $user;
          $responseMessage= 'Profile found';
          $status = true;
        }else{
            $responseMessage = "No User was found";
        }
       }catch(Throwable $ex){
        $responseMessage = 'There was an error';
        $error = LogUtils::errorLog($ex);
      }
      $res = AppUtils::formatJson($responseMessage, $status, $responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'User Profile Details'));
         return $res;
    }
    public function index(Request $request)
    {
       $responseMessage = '';
       $status = false;
       $responseData = null;
       $error = null;
       $users = null;
       try{
        $users = User::all();
        if($users){
          if($request->per_page){
           $users = $users->paginate((int)$request->per_page);
          }
          $responseData = $users;
          $responseMessage= 'User found';
          $status = true;
        }else{
            $responseMessage = "No User was found";
        }
       }catch(Throwable $ex){
        $responseMessage = 'There was an error';
        $error = LogUtils::errorLog($ex);
      }
      $res = AppUtils::formatJson($responseMessage, $status, $responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'User lists'));
         return $res;
    }
    public function show(Request $request,$id)
    {
       $responseMessage = '';
       $status = false;
       $responseData = null;
       $error = null;
       $users = null;
       try{
        $users = User::find($id);
        if($users){
          $responseData = $users;
          $responseMessage= 'User found';
          $status = true;
        }else{
            $responseMessage = "No User was found";
        }
       }catch(Throwable $ex){
        $responseMessage = 'There was an error';
        $error = LogUtils::errorLog($ex);
      }
      $res = AppUtils::formatJson($responseMessage, $status, $responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'User lists'));
         return $res;
    }
}
