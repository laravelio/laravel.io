<?php namespace Lio\Comments;

use McCool\LaravelAutoPresenter\BasePresenter;

class CommentPresenter extends BasePresenter
{
    public function forumThreadUrl()
    {
        $comment = $this->resource;

        $commentSlug = $comment->slug->slug;
        $forumSlug = $comment->owner->slug;

        return action('Controllers\ForumController@getThread', [$forumSlug, $commentSlug]);
    }
}