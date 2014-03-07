<?php namespace Lio\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Lio\Forum\Threads\Listeners\AttachForumThreadTagsListener;
use Mitch\EventDispatcher\Dispatcher;

class DomainEventServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $dispatcher = $this->app['Mitch\EventDispatcher\Dispatcher'];
        $dispatcher->listenOn('forum.thread_created', new AttachForumThreadTagsListener);
    }
}
