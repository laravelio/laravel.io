<?php namespace Lio\Forum;

interface ForumReplyDeleterObserver
{
    public function forumReplyDeleted($thread);
}