<?php

namespace Lio\ModelFactories;

use Illuminate\Support\ServiceProvider;

class ModelFactoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        return $this->app->bind(ModelFactory::class, EloquentModelFactory::class);
    }
}
