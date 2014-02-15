<?php namespace Controllers\Articles;

use Lio\Articles\ArticleRepository;

class ShowArticleController extends \BaseController
{
    private $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    public function getShow($id)
    {
        $article = $this->articles->requirePublishedArticleById($id);
        $this->title = $article->title;
        $this->view('articles.show', compact('article'));
    }
}