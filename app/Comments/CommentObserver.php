<?php

namespace Lio\Comments;

class CommentObserver
{
    public function created($comment)
    {
        $this->updateForumThreadDetails($comment);
    }

    private function updateForumThreadDetails($comment)
    {
        if ($comment->type == Comment::TYPE_FORUM && $comment->parent) {
            $comment->parent->setMostRecentChild($comment);
        }
    }
}
