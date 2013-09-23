<?php namespace Controllers;

use Lio\Articles\ArticleRepository;

class HomeController extends BaseController
{
    private $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

	public function getIndex()
	{
        $articles = $this->articles->getFeaturedArticles(3);

		$this->view('home.index', compact('articles'));
	}
}