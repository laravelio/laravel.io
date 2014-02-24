<?php namespace Lio\Forum\Replies;

interface ReplyCreatorResponder
{
    public function replyCreationError($errors);
    public function replyCreated($reply);
}
