<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Чтобы auth не искал route('login') и не кидал Route [login] not defined
        $middleware->redirectGuestsTo(fn () => null);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            $map = [
                AuthenticationException::class => [401, 'Unauthenticated'],
                AuthorizationException::class => [403, 'Forbidden'],
                ModelNotFoundException::class => [404, 'Not Found'],
                NotFoundHttpException::class => [404, 'Route Not Found'],
                ValidationException::class => [422, 'Validation Error'],
            ];

            // Значения по умолчанию
            $status = 500;
            $message = 'Server Error';
            $errors = [];

            foreach ($map as $class => [$code, $msg]) {
                if ($e instanceof $class) {
                    $status = $code;
                    $message = $msg;
                    $errors = $e instanceof ValidationException ? $e->errors() : [];
                    break;
                }
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'data' => null,
                'errors' => $errors,
            ], $status);
        });
    })
    ->create();
