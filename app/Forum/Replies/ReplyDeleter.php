<?php
namespace Lio\Forum\Replies;

/**
* This class can call the following methods on the observer object:
*
* replyDeleted($thread)
*/
class ReplyDeleter
{
    public function delete(ReplyDeleterListener $observer, $reply)
    {
        $thread = $reply->thread;
        $reply->delete();

        $thread->updateReplyCount();

        return $observer->replyDeleted($thread);
    }
}
