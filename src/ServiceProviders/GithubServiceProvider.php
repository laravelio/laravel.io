<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('Lio\Github\GistEmbedFormatter', function($app) {
            return new \Lio\Github\GistEmbedFormatter;
        });
    }

    public function provides()
    {
        return ['Lio\Github\GistEmbedFormatter'];
    }
}
