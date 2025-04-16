<?php

use App\Http\Middleware\CheckRoles;
use App\Http\Middleware\NoCache;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LogUserActions;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'CheckRoles' => CheckRoles::class,
            'NoCache' => NoCache::class,
        ]);
        $middleware->append([LogUserActions::class]);
        $middleware->redirectGuestsTo(fn (Request $request) => route('/'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
