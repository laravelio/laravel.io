<?php namespace Lio\Forum;

interface ReplyCreatorListener
{
    public function replyCreationError($errors);
    public function replyCreated($reply);
}