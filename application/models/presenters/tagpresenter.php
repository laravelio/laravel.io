<?php

class TagPresenter extends Presentable
{
    public $resource_name = 'tag';

    public function link()
    {
        return HTML::link_to_action('topics@tag', $this->name, array($this->slug));
    }

    public function topics()
    {
        return $this->cache('topics', function()
        {
            return TopicPresenter::make($this->topic->topics);
        });
    }
}