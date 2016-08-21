<?php

namespace App\Forum;

use Illuminate\Support\ServiceProvider;
use App\Forum\Topics\EloquentTopicRepository;
use App\Forum\Topics\TopicRepository;

class ForumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TopicRepository::class, EloquentTopicRepository::class);
        $this->app->bind(ThreadRepository::class, EloquentThreadRepository::class);
    }
}
