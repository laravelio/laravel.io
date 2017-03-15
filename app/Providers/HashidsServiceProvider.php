<?php

namespace Lio\Providers;

use Hashids\Hashids;
use Illuminate\Support\ServiceProvider;

class HashidsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind([Hashids::class => 'hashids'], function ($app) {
            $key = $app['config']->get('app.key');

            return new Hashids($key, 2);
        });
    }
}
