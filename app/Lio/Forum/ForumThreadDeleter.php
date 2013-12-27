<?php namespace Lio\Forum;

use Lio\Comments\CommentRepository;
use Lio\Forum\ForumSectionCountManager;

/**
* This class can call the following methods on the observer object:
*
* forumThreadDeleted()
*/
class ForumThreadDeleter
{
    protected $comments;
    protected $countManager;

    public function __construct(CommentRepository $comments, ForumSectionCountManager $countManager)
    {
        $this->comments = $comments;
        $this->countManager = $countManager;
    }

    public function delete(ForumThreadDeleterObserver $observer, $thread)
    {
        $thread->delete();
        $this->countManager->cacheSections();
        return $observer->forumThreadDeleted();
    }
}