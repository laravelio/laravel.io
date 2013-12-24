<?php namespace Lio\Forum;

interface ForumReplyCreatorObserver
{
    public function forumReplyValidationError($errors);
    public function forumReplyCreated($reply);
}