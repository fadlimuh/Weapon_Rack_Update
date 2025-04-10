<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Http\Middleware\HandleCors::class,
        // Middleware lainnya...
    ];

    protected $middlewareGroups = [
        'web' => [
            // ...existing middleware...
            \App\Http\Middleware\LanguageSwitcher::class,
        ],
    ];
}
