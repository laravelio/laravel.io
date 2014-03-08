<?php namespace Lio\Forum\Replies\Events;

use Mitch\EventDispatcher\Event;

class ReplyCreatedEvent implements Event
{
    private $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function getName()
    {
        return 'forum.reply_created';
    }
}
