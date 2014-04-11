<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Lio\Events\Dispatcher;

class DomainEventServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton('Lio\Events\Dispatcher', function($app) {
            $dispatcher = new Dispatcher;

            return $dispatcher;
        });
    }
}
