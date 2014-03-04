<?php namespace Lio\Bin\Events;

class PasteCreatedEvent
{
    public $paste;

    public function __construct($paste)
    {
        $this->paste = $paste;
    }
}