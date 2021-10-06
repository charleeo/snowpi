<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\CreateAdminUserRequest;
use App\Models\Admin;
use App\Models\User;
use App\Services\AppUtils;
use App\Services\LogUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AdminController extends Controller
{
    public function createAdminUser(CreateAdminUserRequest $request){
        $responseMessage = '';
        $error = null;
        $responseData = null;
        $status = false;
        $admin =null; 
        $data = $request->validated();      
       try{
           $admin = new Admin();
           $admin->email = $data['email'];
           $admin->name = $data['name'];
           $admin->password = Hash::make($data['password']);
           if($admin->save()){
               $responseMessage ="Admin record created successfully";
               $status=true;
           }else{
               $responseMessage="Could not create record";
           }
           $responseData = $admin;
       }catch(Throwable $e){
           $error = LogUtils::errorLog($e);
           $responseMessage="There was an error";
       }
       $res= AppUtils::formatJson($responseMessage,$status,$responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res,'RegisterController@register'));
         return $res;        
    }

    public function adminLogin(AdminLoginRequest $request){
        $status=false;
        $error = false;
        $responseData=null;
        $responseMessage = '';
        $data = $request->validated();

        try{

            $user  = Admin::where('email', $request->email)->first();

            if(Hash::check($request->password, $user->password)){      
                
                $tokenResult = $user->createToken(config('const.token'));

                if ($request->remember_me) {
                    $tokenResult->expires_at = Carbon::now()->addWeeks(1);
                }

                $responseData = [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
                ];
                $status =true;
            }else{
                $responseMessage= 'Invalid credentials';
            }

        }catch(Throwable $ex){
            $responseMessage = 'Error has occured.';
            $error = LogUtils::errorLog($ex);
        }

        $res= AppUtils::formatJson($responseMessage,$status,$responseData);
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res,'AdminController@register'));
         return $res; 
    }

    public function authAdmin(Request $request){
       $admin = Auth::guard('adminapi')->user();
       return $admin;
    }
}
