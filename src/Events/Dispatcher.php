<?php namespace Lio\Events;

class Dispatcher
{
    private $listeners = [];

    public function dispatch($event)
    {
        if (is_array($event)) {
            $this->fireEvents($event);
            return;
        }

        $this->fireEvent($event);
    }

    public function addListener($name, Listener $listener)
    {
        $this->listeners[$name][] = $listener;
    }

    private function fireEvents(array $events)
    {
        foreach ($events as $event) {
            $this->fireEvent($event);
        }
    }

    private function fireEvent(Event $event)
    {
        $listeners = $this->getListeners($event->getName());

        if ( ! $listeners) {
            return;
        }

        foreach ($listeners as $listener) {
            $listener->handle($event);
        }
    }

    private function getListeners($name)
    {
        if ( ! $this->hasListeners($name)) {
            return;
        }

        return $this->listeners[$name];
    }

    private function hasListeners($name)
    {
        return isset($this->listeners[$name]);
    }
}
