<?php namespace Lio\Forum;

use Lio\Comments\CommentRepository;
use Lio\Forum\ForumSectionCountManager;

/**
* This class can call the following methods on the observer object:
*
* forumReplyDeleted($thread)
*/
class ForumReplyDeleter
{
    protected $comments;
    protected $countManager;

    public function __construct(CommentRepository $comments, ForumSectionCountManager $countManager)
    {
        $this->comments = $comments;
        $this->countManager = $countManager;
    }

    public function delete(ForumReplyDeleterObserver $observer, $reply)
    {
        $thread = $reply->parent;
        $reply->delete();

        $thread->updateChildCount();
        $this->countManager->cacheSections();
        return $observer->forumReplyDeleted($thread);
    }
}