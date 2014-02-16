<?php

use Lio\Articles\ArticleCreator;
use Lio\Articles\ArticleCreatorObserver;
use Lio\Articles\ArticleForm;
use Lio\Tags\TagRepository;

class CreateArticleController extends BaseController implements ArticleCreatorObserver
{
    private $creator;
    private $tags;

    public function __construct(ArticleCreator $creator, TagRepository $tags)
    {
        $this->creator = $creator;
        $this->tags = $tags;
    }

    public function getCreate()
    {
        $tags = $this->tags->getAllForArticles();
        $this->view('articles.create', compact('tags'));
    }

    public function postCreate()
    {
        return $this->creator->create($this, Input::all(), Auth::user(), new ArticleForm);
    }

    public function articleCreationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function articleCreated($article)
    {
        return $this->redirectAction('Controllers\Articles\ShowArticleController@getShowThread', [$article->slug]);
    }
}
