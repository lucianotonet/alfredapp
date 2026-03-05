<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
class Kernel extends HttpKernel
{
    protected $middleware = [];
    protected $middlewareGroups = ['web' => [], 'api' => []];
    protected $routeMiddleware = ['auth' => \App\Http\Middleware\Authenticate::class, 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, 'csrf' => VerifyCsrfToken::class::class];
}
