<?php

class Topic extends EloquentBaseModel\Base
{
	const STATUS_DRAFT     = 0;
	const STATUS_PUBLISHED = 1;

	public $includes = array('author');

	public static function published()
	{
		return static::where('status', '=', Topic::STATUS_PUBLISHED);
	}

	public static function find_published($topic_id)
	{
		return static::published()->where('id', '=', $topic_id)->first();
	}

	public static function tag_index($tag)
	{
		return static::published()->order_by('created_at', 'desc');
	}

	public static function recent($count = 5)
	{
		return static::with('author')->published()->order_by('created_at', 'desc')->take($count)->get();
	}

	public function author()
	{
		return $this->belongs_to('User', 'user_id');
	}

	public function tags()
	{
		return $this->has_many_and_belongs_to('Tag');
	}

	public function get_next()
	{
		return static::published()->where('id', '>', $this->id)->order_by('created_at', 'asc')->first();
	}

	public function get_previous()
	{
		return static::published()->where('id', '<', $this->id)->order_by('created_at', 'desc')->first();
	}
}