<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class MarkdownServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('markdown', function($app) {
            return new \Lio\Markdown\Markdown;
        });
    }

    public function provides()
    {
        return ['markdown'];
    }
}