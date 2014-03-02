<?php namespace Lio\Core;

trait DomainEvents
{
    protected $pendingEvents = [];

    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];
        return $events;
    }

    protected function raise($event)
    {
        $this->pendingEvents[] = $event;
    }
}