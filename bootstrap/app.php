<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->shouldRenderJsonWhen(function ($request, Throwable $e) {
            return true;
        });

        $exceptions->render(function (Throwable $e) {

            $status = 500;
            if (method_exists($e, 'getStatusCode')) {
                $status = $e->getStatusCode();
            } elseif (property_exists($e, 'status')) {
                $status = $e->status;
            }

            $message = $e->getMessage() ?: 'Something went wrong';

            return response()->json([
                'status'  => false,
                'code'    => $status,
                'message' => $message,
                'error'   => class_basename($e),
            ], $status);
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
