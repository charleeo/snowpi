<?php

namespace App\Services;

use App\Exceptions\Helpers\Helper;
use App\Http\Requests\SaveStockRequest;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class StockService{
    public function createAstock(SaveStockRequest $request)
    {
        $responseMessage ="";
        $erro =null;
        $status =false;
        $responseData =null;
        $user = User::find(auth()->id());
        try{
            $validatedData = $request->validated();
            $validatedData = $validatedData + ['user_id' => $user->id];
            $stockObject = new Stock($validatedData);
            if ($stockObject->save()) {
                $responseMessage = "Data created";
                $status = true;
            }else {
                $responseMessage = "Could not create data";
            }
            $responseData = $stockObject;
        }catch(Throwable $ex){
           $responseMessage = "There was an error";
           $error = LogUtils::errorLog($ex); 
        }

        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
        Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Store#PostController'));
        return $res;
    }
}