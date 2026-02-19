<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Exceptions\Handler;
use App\Exceptions\LogHandler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    // ! Las excepciones personalizadas funcionaran siempre y cuando se tengan permisos para acceder a los logs en storage
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Throwable $exception) {
            // Reporta el error en el log
            app(LogHandler::class)->reportApiException($exception);

            return false;
        });

        $exceptions->render(function (Throwable $exception, $request) {
            if ($request->is('api/*')) {
                // Usa la clase ApiExceptionHandler para manejar el error
                return app(Handler::class)->renderApiException($exception);
            }

            return [
                "status" => false
            ];
        });
    })->create();
