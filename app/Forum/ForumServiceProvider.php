<?php

namespace Lio\Forum;

use Illuminate\Support\ServiceProvider;

class ForumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ThreadRepository::class, EloquentThreadRepository::class);
    }
}
