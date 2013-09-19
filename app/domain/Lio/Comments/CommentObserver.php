<?php namespace Lio\Comments;

class CommentObserver
{
    public function created($comment)
    {
        $this->processForumComment($comment);
        $this->processParentComment($comment);
    }

    private processForumComment($comment)
    {
        if ($comment->owner_type == 'Lio\Forum\ForumCategory') {
            $comment->owner->setMostRecentChild($comment);
        }
    }

    private processParentComment($comment)
    {
        if ($comment->parent) {
            $comment->parent->updateChildCount();
        }
    }
}