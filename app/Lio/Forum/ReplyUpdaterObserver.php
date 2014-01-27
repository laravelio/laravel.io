<?php namespace Lio\Forum;

interface ReplyUpdaterObserver
{
    public function replyUpdateError($errors);
    public function replyUpdated($reply);
}