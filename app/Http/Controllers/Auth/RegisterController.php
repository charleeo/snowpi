<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AppUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registerUser(Request $request){
       $validatedData = $request->validate([
        'email'=>['required','email','string','max:225'],
        'name' => ['required','min:2','max:225','string']
       ]);
       $userIsSaved = false;
       $user = new User();
       $status = false;
       $user->email = $request->email;
       $password = Hash::make($request->password);
       $user->name = $request->name;
       $user->password = $password;
       $userIsSaved = $user->save();
       if($userIsSaved){
           $message = "record created successfully";
           $status =true;
           return AppUtils::formatJson($message,$status,$validatedData);
       }
    }
}
