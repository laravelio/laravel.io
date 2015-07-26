<?php
namespace Lio\Providers;

use App;
use Auth;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Lio\Core\Exceptions\NotAuthorizedException;
use Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Lio\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        Route::filter('has_role', function($route, $request, $parameters) {
            $allowedRoles = explode(',', $parameters);

            if (Auth::check() && Auth::user()->hasRoles($allowedRoles)) {
                return;
            }

            throw new NotAuthorizedException(Auth::user()->name . ' does not have the required role(s): ' . $parameters);
        });

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
