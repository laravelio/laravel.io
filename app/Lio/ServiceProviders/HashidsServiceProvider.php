<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Hashids\Hashids;

class HashidsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('hashids', function() {
            $key = $this->app['config']->get('app.key');
            return new Hashids($key, 2);
        });
    }

    public function register() {
        return ['hashids'];
    }
}
