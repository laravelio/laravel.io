<?php

class UserPresenter extends Presenter
{
	public $resource_name = 'user';

	public function image($size = 80)
	{
		if(!$this->email)
		{
			return false;
		}

		return Gravitas\API::url($this->email, $size);
	}

    public function twitter_link($attributes = array())
    {
        if(!$this->twitter)
        {
            return $this->name;
        }

        return HTML::link('http://twitter.com/' . $this->twitter, $this->name, $attributes);
    }
}