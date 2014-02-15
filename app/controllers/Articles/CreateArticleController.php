<?php namespace Controllers\Articles;

use Lio\Tags\TagRepository;
use Lio\Articles\ArticleRepository;

class CreateArticleController extends \BaseController
{
    private $articles;
    private $tags;

    public function __construct(ArticleRepository $articles, TagRepository $tags)
    {
        $this->articles = $articles;
        $this->tags = $tags;
    }

    public function getCreate()
    {
        $tags = $this->tags->getAllForArticles();
        $this->view('articles.create', compact('tags'));
    }

    public function postCreate()
    {

    }
}