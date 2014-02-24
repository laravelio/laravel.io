<?php  namespace Lio\Core; 

trait EventDispatcher
{
    protected $pendingEvents = [];

    protected function addEvent($event)
    {
        $this->pendingEvents[] = $event;
    }

    protected function dispatchEvents()
    {
        foreach ($this->pendingEvents as $event) {
            $event->run();
        }
    }
} 
