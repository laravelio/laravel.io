<?php namespace Lio\Comments;

class CommentObserver
{
    public function created($comment)
    {
        $this->updateForumThreadDetails($comment);
        $this->updateArticleDetails($comment);
    }

    private function updateForumThreadDetails($comment)
    {
        if ($comment->type == Comment::TYPE_FORUM && $comment->parent) {
            $comment->parent->setMostRecentChild($comment);
        }
    }

    private function updateArticleDetails($comment)
    {
        if ($comment->type == Comment::TYPE_ARTICLE) {
            $comment->owner->updateCommentCount();
        }
    }
}