<?php namespace Lio\Forum;

interface ReplyCreatorObserver
{
    public function replyCreationError($errors);
    public function replyCreated($reply);
}