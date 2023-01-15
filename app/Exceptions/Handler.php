<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Exception $exception, $request) {
            if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
                return response()->json(['User have not permission for this page access.']);
            }

            if ($exception instanceof ModelNotFoundException) {
                $modelName = strtolower(class_basename($exception->getModel()));
                return response()->json(["errors" => [
                    "message" => "The {$modelName} was not found in the database"
                ]], 404);
            }

            if($exception instanceof NotFoundHttpException){
                return response()->json(["errors" => [
                    "message" => "The specified URL can't be found"
                ]], 404);
            }

            if($exception instanceof MethodNotAllowedHttpException){
                return response()->json(["errors" => [
                    "message" => "The specified method for this request is invalid"
                ]], 405);
            }

            if($exception instanceof ValidationException){
                return $this->convertValidationExceptionToResponse($exception, $request);
            }

            if($exception instanceof AuthenticationException){
                return $this->unauthenticated($request, $exception);
            }


            if($exception instanceof QueryException){
                $errorCode = $exception->errorInfo[1];
                if ($errorCode == 1451) {
                    return response()->json(["errors" => [
                        "message" => "Can't remove this resource permanently. It is related with any other resoource."
                    ]], 409);
                }
            }

            if($exception instanceof HttpException){
                return response()->json(["errors" => [
                    "message" => $exception->getMessage()
                ]], $exception->getStatusCode());
            }


            // return response()->json(["errors" => [
            //     "message" => 'Unexpected exception, please try later'
            // ]], 500);

        });
    }


     /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }
        return $this->invalidJson($request, $e);
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}
