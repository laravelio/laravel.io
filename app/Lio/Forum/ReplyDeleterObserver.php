<?php namespace Lio\Forum;

interface ReplyDeleterObserver
{
    public function replyDeleted($thread);
}