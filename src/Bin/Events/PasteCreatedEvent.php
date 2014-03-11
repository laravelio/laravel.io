<?php namespace Lio\Bin\Events;

use Mitch\EventDispatcher\Event;

class PasteCreatedEvent implements Event
{
    public $paste;

    public function __construct($paste)
    {
        $this->paste = $paste;
    }

    public function getName()
    {
        return 'PasteCreated';
    }
}
