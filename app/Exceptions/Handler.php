<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Propaganistas\LaravelPhone\Exceptions\NumberParseException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'errors' => [
                    'status' => '404',
                    'title' => 'Not Found',
                    'detail' => 'Data not found.',
                ],
            ], 404);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'errors' => [
                    'status' => '403',
                    'title' => 'Unauthorized',
                    'detail' => 'This action is unauthorized.',
                ],
            ], 403);
        }

        if ($exception instanceof NumberParseException or $exception instanceof \libphonenumber\NumberParseException) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'phone' => [
                        $exception->getMessage(),
                    ],
                ],
            ], 422);
        }

        return parent::render($request, $exception);
    }
}
