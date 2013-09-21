<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('github', function($app) {
            return \OAuth::consumer('GitHub');
        });
    }

    public function provides()
    {
        return ['github'];
    }
}