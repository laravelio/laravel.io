<?php namespace Lio\Forum;

interface ForumThreadUpdaterObserver
{
    public function forumThreadValidationError($errors);
    public function forumThreadUpdated($thread);
}