<?php

use Lio\Articles\ArticleRepository;
use Lio\Comments\CommentRepository;

class HomeController extends BaseController
{
    private $articles;

    public function __construct(ArticleRepository $articles, CommentRepository $comments)
    {
        $this->articles = $articles;
        $this->comments = $comments;
    }

	public function getIndex()
	{
        return Redirect::action('ForumThreadController@getIndex');

        $articles = $this->articles->getFeaturedArticles(3);
        $threads  = $this->comments->getFeaturedForumThreads(3);

		$this->view('home.index', compact('articles', 'threads'));
	}
}