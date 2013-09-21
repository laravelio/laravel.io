<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind('faker', function($app) {
            return \Faker\Factory::create();
        });
    }

    public function provides()
    {
        return ['faker'];
    }
}