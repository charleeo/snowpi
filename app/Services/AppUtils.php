<?php

namespace App\Services;

final class AppUtils {
   public static function formatJson(string $message, bool $status=false, $data=null){
     
      return response()->json(
        [
            'status' => $status,
            'response' => $data,
            'message' => $message,
        ]
      );
    }
    
}