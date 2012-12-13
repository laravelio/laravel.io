<?php

class TagPresenter extends Presenter
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
			return new TopicPresenter($this->topic->topics);
		});
	}
}