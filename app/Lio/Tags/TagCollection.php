<?php namespace Lio\Tags;

use HTML;

class TagCollection extends \Illuminate\Database\Eloquent\Collection
{
    public function getTagList()
    {
        $tagLinks = [];

        foreach ($this->items as $item) {
            $tagLinks[] = HTML::link(action('ForumThreadsController@getIndex') . '?tags=' . $item->slug, $item->name);
        }

        return implode(', ', $tagLinks);
    }
}