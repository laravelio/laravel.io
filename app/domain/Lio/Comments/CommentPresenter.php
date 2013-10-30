<?php namespace Lio\Comments;

use McCool\LaravelAutoPresenter\BasePresenter;
use App;

class CommentPresenter extends BasePresenter
{
    public function forumThreadUrl()
    {
        $slug = $this->resource->slug;

        if ( ! $slug) return '';

        return action('ForumController@getThread', [$slug->slug]);
    }

    public function commentUrl()
    {
        $slug = $this->resource->parent->slug;

        if ( ! $slug) return '';

        $url = action('ForumController@getThread', [$slug->slug]);
        return $url . "#comment-{$this->id}";
    }

    public function child_count_label()
    {
        if ($this->resource->child_count == 0) {
            return '0 Responses';
        } elseif($this->resource->child_count == 1) {
            return '1 Response';
        }

        return $this->resource->child_count . ' Responses';
    }

    public function created_ago()
    {
        return $this->resource->created_at->diffForHumans();
    }

    public function body()
    {
        return App::make('markdown')->transform($this->resource->body);
    }
}