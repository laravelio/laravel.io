<?php namespace Lio\Forum\Replies;

interface ReplyUpdaterResponder
{
    public function replyUpdateError($errors);
    public function replyUpdated($reply);
}
