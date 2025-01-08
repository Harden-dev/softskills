<?php

use App\Http\Middleware\IsAdmin;
use App\Jobs\PublishScheduledArticles;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias(['admin' => IsAdmin::class]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->job(new PublishScheduledArticles())->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        if ($exceptions instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['error' => 'Authozation Token is Expired'], 401);
        }
        if ($exceptions instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['error' => 'Token is Invalid'], 401);
        }
        if ($exceptions instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
            return response()->json(['error' => 'Token is Blacklisted'], 401);
        }
        if ($exceptions instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
            return response()->json(['error' => 'Token is not provided'], 401);
        }
    })->create();

    