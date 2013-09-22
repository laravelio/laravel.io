<?php namespace Controllers;

use Lio\Articles\ArticleRepository;
use Lio\Articles\TagRepository;

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
        $navTags  = $this->tags->getAll();

        $this->view('articles.index', compact('articles', 'navTags'));
    }
}