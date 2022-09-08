<?php

namespace App\Services;

use App\Exceptions\Helpers\Helper;
use Illuminate\Http\Request;
use Throwable;

class UsersService {
    public function createUser(Request $request)
    {
        $responseMessage = '';
        $status = false;
        $responseData = null;
        $error = null;
        try
        {
            
        }catch(Throwable $ex){
          $responseMessage = 'There was an error';
          $error = LogUtils::errorLog($ex);

        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
           Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store#PostController'));
           return $res;
    }
}