<?php

namespace Lio\Tags;

use Illuminate\Support\ServiceProvider;

class TagServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TagRepository::class, EloquentTagRepository::class);
    }
}
