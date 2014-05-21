<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Event, App;

class ForumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Lio\Forum\ThreadRepository', 'Lio\Forum\EloquentThreadRepository');
        $this->app->bind('Lio\Forum\ReplyRepository', 'Lio\Forum\EloquentReplyRepository');
    }
}
