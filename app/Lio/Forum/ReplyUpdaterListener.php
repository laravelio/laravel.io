<?php namespace Lio\Forum;

interface ReplyUpdaterListener
{
    public function replyUpdateError($errors);
    public function replyUpdated($reply);
}