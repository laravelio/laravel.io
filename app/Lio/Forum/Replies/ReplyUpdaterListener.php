<?php namespace Lio\Forum\Replies;

interface ReplyUpdaterListener
{
    public function replyUpdateError($errors);
    public function replyUpdated($reply);
}
