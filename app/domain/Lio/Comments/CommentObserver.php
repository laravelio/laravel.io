<?php namespace Lio\Comments;

class CommentObserver
{
    public function created($comment)
    {
        $this->processForumComment($comment);
        $this->processParentComment($comment);
    }

    private function processForumComment($comment)
    {
        if ($comment->owner_type == 'Lio\Forum\ForumCategory') {
            $comment->owner->setMostRecentChild($comment);
        }
    }

    private function processParentComment($comment)
    {
        if ($comment->parent) {
            $comment->parent->updateChildCount();
        }
    }
}