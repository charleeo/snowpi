<?php

namespace App\Exceptions;

use App\Exceptions\Helpers\Helper;
use App\Services\AppUtils;
use App\Services\LogUtils;
use App\Services\ValidationUtils;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // handle validation exception
        if($exception instanceof ValidationException) {
            return $this->handleValidationException($exception, $request);
        }

        // handle all 404
        if ($exception instanceof NotFoundHttpException && $request->wantsJson()) {
            // package the response data
            $res = AppUtils::formatJson("404, Not Found!", false, null);
            // write to log
           Helper::write_log(LogUtils::getLogData($request, $res, '404'));
            // return response
            return response()->json($res, Response::HTTP_OK);
        }

        // handle all AuthorizationException
        elseif ($exception instanceof AuthorizationException && $request->wantsJson()) {
            // package the response data
            $res = AppUtils::formatJson($exception->getMessage() ?? "Access Denied! You don't have the right permissions to do that", false, null);
            // write to log
           Helper::write_log(LogUtils::getLogData($request, $res, 'access denied'));
            // return response
            return response()->json($res, Response::HTTP_OK);
        } 
    
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception) 
    {
        if ($request->expectsJson()) {

            $res = [
                'status' => false,
                'response' => null,
                'message' => 'Valid auth credentials required',
                'code' => 401,
                'authenticated' => false,
            ];

            // write to log
           Helper::write_log(LogUtils::getLogData($request, $res, 'authentication failed'));

            return response()->json($res, 200);
        }

        return redirect()->guest('login');
    }

    /**
     * ValidationException
     * Parameters did not pass validation
     *
     * @param ValidationException $exception
     * @return \Illuminate\Http\Response 422 with custom response structure
     */
    protected function handleValidationException(ValidationException $exception, Request $request)
    {
        $validationUtils = new ValidationUtils();
        return $validationUtils->validationErrorResponse($exception, $request);
    }
}
