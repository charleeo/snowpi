<?php

namespace App\Http\Controllers;

use App\Services\AppUtils;
use Illuminate\Http\Request;

class AuthRegisterController extends Controller
{
    public function store(Request $request){
     $data = [
         'name'=>"Charles",
         "age"=>34,
         "mirital_status"=>"single"
     ];
     $message = "working";
     $status =true;
     return AppUtils::formatJson($message, $status, $data);
    } 
}
