<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton('Lio\CommandBus\CommandBus', 'Lio\CommandBus\ValidationCommandBus');
    }
}
