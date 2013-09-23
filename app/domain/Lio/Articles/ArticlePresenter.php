<?php namespace Lio\Articles;

use McCool\LaravelAutoPresenter\BasePresenter;
use App;

class ArticlePresenter extends BasePresenter
{
    public function content()
    {
        return App::make('markdown.parser')->transformMarkdown($this->resource->content);
    }

    public function summary()
    {
        return \Str::words($this->resource->content, 200);
    }

    public function published_at()
    {
        return $this->published_at->toFormattedDateString();
    }

    public function editUrl()
    {
        return action('Controllers\ArticlesController@getEdit', [$this->resource->id]);
    }
}