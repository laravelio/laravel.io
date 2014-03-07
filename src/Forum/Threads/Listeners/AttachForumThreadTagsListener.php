<?php namespace Lio\Forum\Threads\Listeners; 

use Mitch\EventDispatcher\Event;
use Mitch\EventDispatcher\Listener;

class AttachForumThreadTagsListener implements Listener
{
    public function handle(Event $event)
    {
        $event->thread->tags()->sync($event->tagIds);
    }
}
