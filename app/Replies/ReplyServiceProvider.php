<?php

namespace App\Replies;

use Illuminate\Support\ServiceProvider;

class ReplyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ReplyRepository::class, EloquentReplyRepository::class);
    }
}
