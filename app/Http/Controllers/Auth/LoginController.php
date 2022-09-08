<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\AppUtils;
use App\Services\LogUtils;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
 
    public function login(Request $request)
    {
        $status=false;
        $error = false;
        $responseData=null;
        $responseMessage = '';
        $request->validate(
                [
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
                ]
            );
        try{

            $user  = User::where('email', $request->email)->first();

            if($user && Hash::check($request->password, $user->password)){      
                if ($request->remember_me) {
                    Passport::personalAccessTokensExpireIn(Carbon::now()->addWeeks(config('const.remember_token_expires_in')));
                }
                
                $tokenResult = $user->createToken(config('const.token'));

                $token = $tokenResult->token;
                $token->save();
                $user->save();
                $responseData = [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                    "user" => [
                        'email'=>$user->email,
                        'id'=>$user->id,
                        'name'=>$user->name
                        ]
                ];
                $status =true;
                $responseMessage = "Login successfully";
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

    public function socialLogin(Request $request)
    {
        $status=false;
        $error = false;
        $responseData=null;
        $responseMessage = '';
    try{
        $social= Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl();
        $responseData = $social;
        $status=true;
    }catch(Throwable $ex){
        $responseMessage = 'Error has occured.';
        $error = LogUtils::errorLog($ex);
    }
    $res= AppUtils::formatJson($responseMessage,$status,$responseData);
     Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res,'AdminController@register'));
     return $res;
    }
}
