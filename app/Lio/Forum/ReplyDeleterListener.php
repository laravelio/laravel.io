<?php namespace Lio\Forum;

interface ReplyDeleterListener
{
    public function replyDeleted($thread);
}