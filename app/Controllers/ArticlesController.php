<?php namespace Controllers;

use Lio\Articles\ArticleRepository;
use Lio\Tags\TagRepository;

class ArticlesController extends BaseController
{
    private $articles;
    private $tags;

    public function __construct(ArticleRepository $articles, TagRepository $tags)
    {
        $this->tags     = $tags;
        $this->articles = $articles;
    }

    public function getIndex()
    {
        $articles = $this->articles->getAll();

        $this->view('articles.index', compact('articles'));
    }

    public function getCompose()
    {
        $this->view('articles.compose');
    }

    public function postCompose()
    {

    }
}