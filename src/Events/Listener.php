<?php namespace Lio\Events;

interface Listener
{
    public function handle(Event $event);
}
