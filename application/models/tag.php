<?php

class Tag extends EloquentBaseModel\Base
{
	const TYPE_TAG = 0;

	public static function find_by_slug($slug)
	{
		return static::where('slug', '=', $slug)->first();
	}

	public function topics()
	{
		return $this->has_many_and_belongs_to('Topic');
	}
}