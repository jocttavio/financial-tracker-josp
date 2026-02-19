<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Http\Events\RequestHandled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void //auditorias
    {        
        // programar para extraer la info del token y usarla en las controladores
        Event::listen(RequestHandled::class, function ($event){
            $responseContent = $event->response->getContent();
            
            if ($responseContent !== '') {
                $response = json_decode($responseContent, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($response['status']) && $response['status']) {
                    $route = Route::getCurrentRoute();                
                    if ($route) {
                        $routeAction = $route->getAction();
                        $action = $routeAction['controller'];
                        list($controller, $method) = explode('@', $action);
                        $httpMethods = $route->methods();
                    }else{
                        $controller = null;
                        $action     = null;
                        $method     = null;
                        $httpMethods = null;
                    }

                    Log::channel('successful_requests')->info('Petición exitosa:', [
                        'controller'    => $controller,
                        'action'        => $method,
                        'url'           => $event->request->fullUrl(),
                        'method'        => $event->request->method(),
                        'payload'       => $event->request->all(),
                        'response'      => $response,
                        'httpMethods'   => $httpMethods,
                        'ip_address'    => $event->request->ip()
                    ]);
                }
            }

        });
    }
}