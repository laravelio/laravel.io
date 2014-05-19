<?php namespace Lio\Events;

class DispatcherStub extends Dispatcher
{
    private $dispatchedEvents;

    public function dispatch($events)
    {
        $this->dispatchedEvents = $events;
    }

    public function getDispatchedEvents()
    {
        return $this->dispatchedEvents;
    }
} 
