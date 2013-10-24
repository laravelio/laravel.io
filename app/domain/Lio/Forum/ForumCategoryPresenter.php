<?php namespace Lio\Forum;

use McCool\LaravelAutoPresenter\BasePresenter;

class ForumCategoryPresenter extends BasePresenter
{
    public function categoryIndexUrl()
    {
        return action('Controllers\ForumController@getCategory', [$this->resource->slug]);
    }
}