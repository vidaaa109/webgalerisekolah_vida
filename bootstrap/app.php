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
    ->withMiddleware(function (Middleware $middleware): void {
        // Redirect to appropriate login based on guard
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            if ($request->is('petugas') || $request->is('petugas/*')) {
                return route('petugas.login');
            }
            return route('user.login');
        });
        
        // Trust proxies for HTTPS
        $middleware->trustProxies();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
