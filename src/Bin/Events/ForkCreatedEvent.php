<?php  namespace Lio\Bin\Events;

use Lio\Bin\Paste;
use Mitch\EventDispatcher\Event;

class ForkCreatedEvent implements Event
{
    public $fork;

    public function __construct(Paste $fork)
    {
        $this->fork = $fork;
    }

    public function getName()
    {
        return 'ForkCreated';
    }
}
