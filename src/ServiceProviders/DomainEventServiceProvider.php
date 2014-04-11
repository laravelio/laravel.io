<?php namespace Lio\ServiceProviders;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Lio\Forum\Threads\Listeners;

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
