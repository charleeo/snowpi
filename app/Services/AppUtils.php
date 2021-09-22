<?php

namespace App\Services;

use App\Exceptions\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
final class AppUtils {
   public static function formatJson(string $message, bool $status=false, $data=null){
   $res=  [
        'status' => $status,
        'response' => $data,
        'message' => $message,
   ];
        return response()->json($res, Response::HTTP_OK);
    }

}