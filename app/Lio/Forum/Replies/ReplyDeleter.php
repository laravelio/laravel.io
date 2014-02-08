<?php namespace Lio\Forum\Replies;

use Lio\Comments\CommentRepository;

/**
* This class can call the following methods on the observer object:
*
* replyDeleted($thread)
*/
class ReplyDeleter
{
    protected $comments;

    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    public function delete(ReplyDeleterListener $observer, $reply)
    {
        $thread = $reply->thread;
        $reply->delete();

        $thread->updateReplyCount();

        return $observer->replyDeleted($thread);
    }
}
