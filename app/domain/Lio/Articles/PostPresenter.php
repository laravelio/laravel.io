<?php namespace Lio\Blog;

use McCool\LaravelAutoPresenter\BasePresenter;

use Carbon\Carbon;
use App;

class PostPresenter extends BasePresenter
{
    public function body()
    {
        return App::make('markdown.parser')->transformMarkdown($this->resource->body);
    }

    public function published_at()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->resource->published_at, 'Europe/Berlin')->toFormattedDateString();
    }
}