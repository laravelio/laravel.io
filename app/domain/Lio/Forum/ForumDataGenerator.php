<?php namespace Lio\Forum;

use Lio\Forum\ForumCategoryRepository;

class ForumDataGenerator
{
	private $generator;
	private $categories;

	public function __construct($generator, ForumCategoryRepository $categories)
	{
		$this->generator  = $generator;
		$this->categories = $categories;
	}

	public function generate($count)
	{
		die('bob');
	}
}