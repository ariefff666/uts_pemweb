<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Jika menggunakan verifikasi email
            'role' => RoleMiddleware::class,
        ]);

        // Anda juga bisa mendaftarkan global middleware di sini jika perlu:
        // $middleware->append(GlobalMiddlewareAnu::class);

        // Atau middleware groups:
        // $middleware->group('web', [
        //     \App\Http\Middleware\EncryptCookies::class,
        //     // ... middleware lain untuk grup 'web'
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
