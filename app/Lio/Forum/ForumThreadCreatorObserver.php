<?php namespace Lio\Forum;

interface ForumThreadCreatorObserver
{
    public function forumThreadValidationError($errors);
    public function forumThreadCreated($thread);
}