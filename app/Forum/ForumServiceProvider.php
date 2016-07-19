<?php

namespace Lio\Forum;

use Illuminate\Support\ServiceProvider;
use Lio\Forum\Topics\EloquentTopicRepository;
use Lio\Forum\Topics\TopicRepository;

class ForumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TopicRepository::class, EloquentTopicRepository::class);
        $this->app->bind(ThreadRepository::class, EloquentThreadRepository::class);
    }
}
