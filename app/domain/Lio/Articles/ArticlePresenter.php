<?php namespace Lio\Articles;

use McCool\LaravelAutoPresenter\BasePresenter;
use App;

class ArticlePresenter extends BasePresenter
{
    public function content()
    {
        return App::make('markdown.parser')->transformMarkdown($this->resource->content);
    }

    public function comment_count_label()
    {
        if ($this->resource->comment_count == 0) {
            return '0 Comments';
        } elseif($this->resource->comment_count == 1) {
            return '1 Comment';
        }

        return $this->resource->comment_count . ' Comments';
    }

    public function summary()
    {
        return \Str::words($this->resource->content, 200);
    }

    public function published_at()
    {
        return $this->resource->published_at->toFormattedDateString();
    }

    public function published_ago()
    {
        return $this->resource->published_at->diffForHumans();
    }

    public function editUrl()
    {
        return action('Controllers\ArticlesController@getEdit', [$this->resource->id]);
    }

    public function showUrl()
    {
        if ( ! $this->resource->slug) return '';

        return action('Controllers\ArticlesController@getShow', [$this->resource->slug->slug]);
    }
}