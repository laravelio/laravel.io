<?php namespace Lio\Forum\Replies;

interface ReplyDeleterListener
{
    public function replyDeleted($thread);
}