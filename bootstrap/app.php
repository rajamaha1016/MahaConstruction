<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuthenticated::class,
            'admin.api.session' => \App\Http\Middleware\AdminApiSession::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'data'    => null,
                        'errors'  => $e->errors(),
                    ], 422);
                }
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthenticated. Please log in.',
                        'data'    => null,
                        'errors'  => null,
                    ], 401);
                }
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException || $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'The requested resource was not found.',
                        'data'    => null,
                        'errors'  => null,
                    ], 404);
                }
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Access denied. You do not have permission to access this resource.',
                        'data'    => null,
                        'errors'  => null,
                    ], 403);
                }

                $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
                $status = ($status >= 400 && $status < 600) ? $status : 500;
                $message = config('app.debug') ? $e->getMessage() : 'An unexpected server error occurred. Please try again later.';

                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'data'    => null,
                    'errors'  => null,
                ], $status);
            }
        });
    })->create();
