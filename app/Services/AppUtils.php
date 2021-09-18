<?php

namespace App\Services;

use App\Exceptions\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
final class AppUtils {
   public static function formatJson(string $message, bool $status=false, $data=null){
    $request = new Request;
   $res=  [
        'status' => $status,
        'response' => $data,
        'message' => $message,
   ];
        Helper::write_log(LogUtils::getLogData($request, $res, 'validation error'));
        return response()->json($res, Response::HTTP_OK);
    }

}