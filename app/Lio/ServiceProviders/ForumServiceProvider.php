<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Lio\Forum\ForumSectionCountManager;
use Config;

class ForumServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind('Lio\Forum\ForumSectionCountManager', function($app) {
            return new ForumSectionCountManager($app['Lio\Forum\ForumSectionTimestampFetcher'], Config::get('forum.sections'));
        });
    }

    public function boot()
    {
    }

    public function provides()
    {
        return ['Lio\Forum\ForumSectionCountManager'];
    }
}
