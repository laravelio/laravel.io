<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        \Lio\Comments\Comment::observe(new \Lio\Comments\CommentObserver);
    }
}
