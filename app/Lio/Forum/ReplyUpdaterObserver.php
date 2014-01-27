<?php namespace Lio\Forum;

interface ReplyUpdaterObserver
{
    public function forumReplyValidationError($errors);
    public function forumReplyUpdated($reply);
}