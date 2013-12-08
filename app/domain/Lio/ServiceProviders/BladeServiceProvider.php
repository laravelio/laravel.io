<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class BladeProvider extends ServiceProvider
{
    public function register()
    {
        Blade::extend(function($view) {
            return $this->app['Lio\BladeParsing\BladeParser']->parse($view);
        });
    }

    public function boot() {}
}
