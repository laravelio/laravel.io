<?php

class Topics_Controller extends Base_Controller
{
    // topic index page
    public function get_index()
    {
        $recent_topics = TopicPresenter::recent(100);
        
        $this->layout->page_title = "Welcome";

        $this->layout->content = View::make('topics.index')->with('recent_topics', $recent_topics);
    }

    // individual topic page
    public function get_show($topic_id = null, $slug = null)
    {
        $topic = TopicPresenter::find_published($topic_id);
        
        if(is_null($topic))
        {
            return Response::error('404');
        }

        $this->layout->page_title = sprintf("Topic for %s - %s", $topic->published_date, $topic->title);

        $this->layout->content = View::make('topics.show')->with('topic', $topic);
    }

    // page showing topics by tag
    public function get_tag($tag_slug)
    {
        $tag = TagPresenter::find_by_slug($tag_slug);

        if(is_null($tag))
        {
            return Response::error('404');
        }

        $this->layout->page_title = sprintf("Topics by tag: %s", $tag->name);

        $this->layout->content = View::make('topics.tag')->with('tag', $tag);
    }

    // rss feed
    public function get_rss()
    {
        Bundle::start('syndication');

        return Response::make(Syndication::rss2(), 200, array('Content-type' => 'application/rss+xml'));
    }
}