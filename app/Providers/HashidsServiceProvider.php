<?php
namespace Lio\Providers;

use Illuminate\Support\ServiceProvider;
use Hashids\Hashids;

class HashidsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind([Hashids::class => 'hashids'], function($app) {
            $key = $app['config']->get('app.key');

            return new Hashids($key, 2);
        });
    }
}
