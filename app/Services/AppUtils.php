<?php

namespace App\Services;

use App\Exceptions\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
final class AppUtils {
   public static function formatJson(string $message, $status, $data=null,$http=200){
   $res=  [
        'status' => $status,
        'response' => $data,
        'message' => $message,
   ];
        return response()->json($res, $http);
    }

}