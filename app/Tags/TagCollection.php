<?php
namespace Lio\Tags;

class TagCollection extends \Illuminate\Database\Eloquent\Collection
{
    public function getTagList()
    {
        $tagLinks = [];

        foreach ($this->items as $item) {
            $tagLinks[] = '<a href="' . action('Forum\ForumThreadsController@getIndex') . '?tags=' . $item->slug . '">' . $item->name . '</a>';
        }

        return implode(', ', $tagLinks);
    }
}
