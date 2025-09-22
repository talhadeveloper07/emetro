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
        $middleware->validateCsrfTokens(except: [
            '/api/*',
            '/api-login',
            '/payment_methods/paypal/create-billing-agreement',
            '/payment_methods/paypal/execute-billing-agreement',
        ]);
        $middleware->alias([
            'bearer.token' => \App\Http\Middleware\BearerTokenMiddleware::class,
            '2fa' => \App\Http\Middleware\TwoFactorAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
