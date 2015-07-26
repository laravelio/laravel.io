<?php
namespace Lio\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // If a user is logged in, we'll set him as the target user for which the errors will occur.
        if ($this->app['auth']->check()) {
            $this->app['bugsnag']->setUser([
                'name' => $this->app['auth']->user()->name,
                'email' => $this->app['auth']->user()->email
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
