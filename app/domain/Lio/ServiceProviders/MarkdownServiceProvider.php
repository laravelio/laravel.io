<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;

use Event, App;

class MarkdownServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('markdown.parser', function($app) {
            return new \dflydev\markdown\MarkdownParser;
        });
    }

    public function provides()
    {
        return ['markdown.parser'];
    }
}
