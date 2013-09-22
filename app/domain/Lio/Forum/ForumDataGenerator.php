<?php namespace Lio\Forum;

use Lio\Accounts\UserRepository;
use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

class ForumDataGenerator
{
	private $generator;
	private $categories;
	private $comments;
	private $users;

	private $fillUsers;
	private $fillCategories;

	public function __construct($generator, ForumCategoryRepository $categories, CommentRepository $comments, UserRepository $users)
	{
		$this->generator  = $generator;
		$this->categories = $categories;
		$this->comments   = $comments;
		$this->users      = $users;
	}

	public function generate($count)
	{
		$this->fillCategories = $this->categories->getAll();
		$this->fillUsers      = $this->users->getFirstX(10);

		for ($i=0; $i<$count; $i++) {
			echo $i+1;
			echo "(" . number_format(memory_get_usage(true)/1024/1024) . "M)";
			flush();
			$this->createThread();
		}
	}

	private function createThread()
	{
		$user     = $this->fillUsers[rand(0, $this->fillUsers->count()-1)];
		$category = $this->fillCategories[rand(0, $this->fillCategories->count()-1)];

		$thread = $this->comments->getNew([
            'title'         => $this->generator->sentence(rand(3, 12)) . ' ' . rand(0,1000),
            'body'          => $this->generator->text,
            'author_id'     => $user->id,
            'owner_id'      => $category->id,
            'owner_type'    => 'Lio\Forum\ForumCategory',
            'category_slug' => $category->slug,
            'type'          => Comment::TYPE_FORUM,
        ]);

        $thread->save();

		$thread->clearRelationsCache();

        $this->createComments($thread);
	}

	private function createComments(Comment $thread)
	{
		$count = rand(0, 20);

		for ($i=0; $i<$count; $i++) {
			$user = $this->fillUsers[rand(0, $this->fillUsers->count()-1)];

	        $comment = $this->comments->getNew([
	            'body'      => $this->generator->text,
	            'author_id' => $user->id,
	            'parent_id' => $thread->id,
	            'type'      => Comment::TYPE_FORUM,
	        ]);

	        $comment->save();

	        echo ".";
	        flush();
		}
	}
}