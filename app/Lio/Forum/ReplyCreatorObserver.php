<?php namespace Lio\Forum;

interface ReplyCreatorObserver
{
    public function replyValidationError($errors);
    public function replyCreated($reply);
}