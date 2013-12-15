<?php namespace Lio\Comments;

class CommentObserver
{
    public function created($comment)
    {
        $this->updateForumThreadDetails($comment);
    }

    private function updateForumThreadDetails($comment)
    {
        if ($comment->parent) {
            $comment->parent->setMostRecentChild($comment);
        }
    }
}