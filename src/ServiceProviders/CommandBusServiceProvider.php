<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Lio\CommandBus\CommandBus;
use Lio\CommandBus\ValidationBus;

class CommandBusServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton('Lio\CommandBus\CommandBusInterface', function($app) {
            $bus = new CommandBus($app, $app['Lio\CommandBus\CommandHandlerNameInflector']);
            return new ValidationBus($bus);
        });
    }
}
