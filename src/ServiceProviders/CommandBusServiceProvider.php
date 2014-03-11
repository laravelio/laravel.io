<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Lio\CommandBus\CommandBus;
use Lio\CommandBus\ValidationCommandBus;

class CommandBusServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton('Lio\CommandBus\CommandBusInterface', function($app) {
            $inflector = $app['Lio\CommandBus\CommandHandlerNameInflector'];
            $bus = new CommandBus($app, $inflector);
            return new ValidationCommandBus($bus, $app, $inflector);
        });
    }
}
