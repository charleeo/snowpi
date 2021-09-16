<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AppUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function registerUser(RegisterUserRequest $request){
        $status=false;
        $response = null;
        $message = "Error occured";
        $validatedData = $request->validated();
      
       $userIsSaved = false;
       $user = new User();
       $status = false;
       $user->email = $request->email;
       $password = Hash::make($request->password);
       $user->name = $request->name;
       $user->password = $password;
       $userIsSaved = $user->save();
       if($userIsSaved){
           unset($validatedData['password']);
           $message = "record created successfully";
           $status =true;
           return AppUtils::formatJson($message,$status,$validatedData);
       }
    }
}
