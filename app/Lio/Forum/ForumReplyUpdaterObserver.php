<?php namespace Lio\Forum;

interface ForumReplyUpdaterObserver
{
    public function forumReplyValidationError($errors);
    public function forumReplyUpdated($reply);
}