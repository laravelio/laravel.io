<?php namespace Controllers\Articles;

use Illuminate\Http\Request;
use Lio\Tags\TagRepository;
use Lio\Articles\ArticleRepository;

class IndexArticleController extends \BaseController
{
    private $articles;
    private $tags;
    private $request;

    public function __construct(ArticleRepository $articles, TagRepository $tags, Request $request)
    {
        $this->articles = $articles;
        $this->tags = $tags;
        $this->request = $request;
    }

    public function getIndex()
    {
        $tags = $this->tags->getAllTagsBySlug($this->request->input('tags'));
        $articles = $this->articles->getAllPublishedByTagsPaginated($tags);
        $this->title = 'Articles';
        $this->view('articles.index', compact('articles'));
    }
}