<?php

class TopicPresenter extends Presentable
{
    public $resource_name = 'topic';

    public function body()
    {
        return Sparkdown\Markdown($this->topic->body);
    }

    public function url()
    {
        return URL::to_action('topics@show', array($this->id, Str::slug($this->title)));
    }

    public function link($attributes = array())
    {
        return HTML::link_to_action('topics@show', $this->title, array($this->id, Str::slug($this->title)), $attributes);
    }

    public function published_date()
    {
        return date('d-m-y', strtotime($this->created_at));
    }

    public function author()
    {
        return $this->request_cache('author_for_' . $this->id, function()
        {
            return UserPresenter::make($this->topic->author);
        });
    }

    public function tags()
    {
        return $this->request_cache('tags_for_' . $this->id, function()
        {
            return TagPresenter::make($this->topic->tags);
        });
    }

    public function previous()
    {
        return $this->request_cache('previous_topic_for' . $this->id, function()
        {
            return TopicPresenter::make($this->topic->previous);
        });
    }

    public function next()
    {
        return $this->request_cache('next_topic_for_' . $this->id, function()
        {
            return TopicPresenter::make($this->topic->next);
        });
    }   
}