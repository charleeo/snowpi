<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AppDateUtils;
use App\Services\AppUtils;
use App\Services\LogUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class RegisterController extends Controller
{
    // use AuthenticatesUsers;
    protected $maxAttempts;
    protected $decayMinutes;
    public function __construct()
    {
        $this->maxAttempts = config('const.authMaxAttempt');
        $this->decayMinutes = config('const.authThrottleTimeMin');
    }

    public function registerUser(RegisterUserRequest $request){
        $status=false;
        $responseData = null;
        $error =null;
        $responseMessage='';
       $status = false;
       $validatedData = $request->validated();
       
       $validatedData['password'] = bcrypt($request->password);
       try{
           $user = User::create($validatedData) ;      
           $responseMessage = "record created successfully";
           $accessToken = $user->createToken(config('const.token'))->accessToken;
           $status =true;
           $responseData = $accessToken;
           
        }catch(Throwable $ex){
            $responseMessage = "There was an error";
            $error = LogUtils::errorLog($ex);
        }
        
        $res = AppUtils::formatJson($responseMessage,$status,$responseData);
       Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'RegisterContrller@register'));
        return $res;
    }

    public function login(Request $request){
        $status=false;
        $error = false;
        $responseData=null;
        $responseMessage = '';

        $data =$request->validate([
         'email'=>['required','string','email'],
         'password'=>['required','string'],
         'remember_me'=>['nullable','boolean']
        ]);

        try{
            
            if(Auth::attempt($data)){
                // $user  = User::find(auth()->id());
                $user = $request->user();
                
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
         Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res,'RegisterController@register'));
         return $res;        
    }

    
    public function logout(Request $request){
        $responseMessage ='';
        $error = null;
        $status=false;
        try{
            $request->user()->token()->revoke();
            $responseMessage = "Logout successfully";
            $status=true;
        }catch(Throwable $ex){
            $error = LogUtils::errorLog($ex);
            $responseMessage = "There was an error loging you out";
        }
      $res = AppUtils::formatJson($responseMessage,$status);
      Helper::write_log(LogUtils::getLogData($request,$error?$error:$res,'Logging out'));
      return $res;
    }

    public function authUser(Request $request){
        $user = $request->user();
        return $user;
    }
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
    
        throw ValidationException::withMessages([
            $this->username() => 'Maximum auth attempts exceeded. Please try again after ' . AppDateUtils::secondsToTime($seconds),
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    
    }
}
