<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\VerifyApiKey;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verify.apikey' => VerifyApiKey::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                $resp = [
                    "success" => false,
                    "data"    => null,
                    "message" => "Something went wrong!"
                ];

                if ($e instanceof MethodNotAllowedHttpException) {
                    $resp['message'] = 'Method not allowed';
                    return response()->json($resp, 405);
                }

                if ($e instanceof NotFoundHttpException) {
                    $resp['message'] = 'Route not found';
                    return response()->json($resp, 404);
                }

                // if ($e instanceof ValidationException) {
                //     $resp['message'] = 'Validation failed';
                //     $resp['data']    = $e->errors();
                //     return response()->json($resp, 422);
                // }

                // Generic catch-all
                $resp['message'] = $e->getMessage() ?: 'Server error';
                return response()->json($resp, 500);
            }

            // For non-API, fall back to default handling
            return null;
        });
    })->create();
