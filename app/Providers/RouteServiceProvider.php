<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = null;

    public function boot(Router $router)
    {
        parent::boot($router);
    }

    public function map(Router $router)
    {
        if (file_exists(app_path('Http/routes.php'))) {
            $router->group([], function ($router) {
                require app_path('Http/routes.php');
            });
        }
    }
}
