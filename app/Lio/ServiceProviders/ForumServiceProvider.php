<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Lio\Forum\SectionCountManager;
use Config;

class ForumServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind('Lio\Forum\SectionCountManager', function($app) {
            return new SectionCountManager($app['Lio\Forum\SectionTimestampFetcher'], Config::get('forum.sections'));
        });
    }

    public function boot()
    {
    }

    public function provides()
    {
        return ['Lio\Forum\SectionCountManager'];
    }
}
