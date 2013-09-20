<?php namespace Lio\Comments;

use McCool\LaravelAutoPresenter\BasePresenter;

class CommentPresenter extends BasePresenter
{
    public function forumThreadUrl()
    {
        $comment = $this->resource;

        $commentSlug = $comment->slug->slug;
        $forumSlug = $comment->category_slug;

        return action('Controllers\ForumController@getThread', [$forumSlug, $commentSlug]);
    }
}