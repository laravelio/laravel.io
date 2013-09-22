<?php namespace Lio\Articles;

use McCool\LaravelAutoPresenter\BasePresenter;
use App;

class ArticlePresenter extends BasePresenter
{
    public function content()
    {
        return App::make('markdown.parser')->transformMarkdown($this->resource->content);
    }

    public function published_at()
    {
        return $this->published_at->toFormattedDateString();
    }
}