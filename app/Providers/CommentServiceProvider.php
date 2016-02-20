<?php
namespace Lio\Providers;

use Illuminate\Support\ServiceProvider;
use Lio\Comments\Comment;
use Lio\Comments\CommentObserver;

class CommentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Comment::observe(new CommentObserver);
    }

    public function register()
    {
        //
    }
}
