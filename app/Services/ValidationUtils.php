<?php

namespace App\Services;

use App\Exceptions\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

final class ValidationUtils {

   
    public static function startsWithNumber($str) {
        return preg_match('/^\d/', $str) === 1;
    }

    public function validationErrorResponse(ValidationException $exception, Request $request) {
        $errors = $this->formatErrorBlock($exception->validator);

        // package the response data
        $res = AppUtils::formatJson("Validation not passed.", false, $errors);

        // write to log
       Helper::write_log(LogUtils::getLogData($request, $res, 'validation error'));

        // return response
        return $res;
    }

    /**
     * 
     * format and return validation messages
     */
    private function formatErrorBlock($validator)
    {
        // extract errors into array
        $errors = $validator->errors()->toArray();
        $errorResponse = [];

        // loop throtugh the errors and save them in array
        foreach ($errors as $field => $message) {
            $errorField = ['field' => $field];

            foreach ($message as $key => $msg) {
                if ($key) {
                    $errorField['message' . $key] = $msg;
                } else {
                    $errorField['message'] = $msg;
                }
            }

            $errorResponse[] = $errorField;
        }

        return $errorResponse;
    }
}