<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Translation\Exception\InvalidResourceException;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function render($request, $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'errors' => [
                    'status' => "404",
                    'source' => [
                        'pointer' => $exception->getModel()
                    ],
                    'title' => 'ModelNotFoundException',
                    'detail' => $exception->getMessage()
                ]
            ], 404);
        }

        if ($exception instanceof InvalidResourceException) {
            return response()->json([
                'errors' => [
                    'status' => "404",
                    'source' => [
                        'pointer' => ''
                    ],
                    'title' => 'InvalidResourceException',
                    'detail' => 'Entry for '.str_replace('App\\', '', $exception->getModel()).' not found'
                ]
            ], 404);
        }

        if ($exception instanceof \Exception) {
            return response()->json([
                'errors' => [
                    'status' => "500",
                    'source' => [
                        'pointer' => ''
                    ],
                    'title' => $exception->getMessage(),
                    'detail' => $exception->getMessage()
                ]
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
