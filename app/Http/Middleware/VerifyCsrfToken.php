<?php

namespace App\Http\Middleware;
use Route;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    public function handle($request, Closure $next)
    {
        $route = Route::getRoutes()->match($request);
        $routeAction = $route->getAction();
//если роут добавлен в исключение, пропускаем
        if (isset($routeAction['nocsrf']) && $routeAction['nocsrf']) {
            return $next($request);
        }
        return parent::handle($request, $next);
    }


    protected $except = [
        //
    ];

}
