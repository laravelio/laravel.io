<?php

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Lio\Articles\ArticleRepository;
use Lio\CommandBus\CommandBus;
use Lio\Laravel\Laravel;
use Lio\Tags\TagRepository;
use Lio\Articles\Commands;

class ArticlesController extends \BaseController
{
    private $articleRepository;
    private $tagRepository;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Illuminate\Auth\AuthManager
     */
    private $auth;
    private $bus;

    function __construct(ArticleRepository $articleRepository, TagRepository $tagRepository, CommandBus $bus, Request $request, AuthManager $auth)
    {
        $this->articleRepository = $articleRepository;
        $this->tagRepository = $tagRepository;
        $this->request = $request;
        $this->auth = $auth;
        $this->bus = $bus;
    }

    public function getIndex()
    {
        $tags = $this->tagRepository->getAllTagsBySlug($this->request->input('tags'));
        $articles = $this->articleRepository->getAllPublishedByTagsPaginated($tags);

        $this->title = 'Articles';
        $this->view('articles.index', compact('articles'));
    }

    public function getShow($articleSlug)
    {
        $article = $this->articleRepository->requireBySlug($articleSlug);

        $this->title = $article->title;
        $this->view('articles.show', compact('article'));
    }

    public function getCreate()
    {
        $tags = $this->tagRepository->getAllForForum();
        $versions = Thread::$laravelVersions;

        $this->title = "Create Forum Thread";
        $this->view('forum.threads.create', compact('tags', 'versions'));
    }

    public function postCreate()
    {
        $command = new Commands\CreateArticleCommand(
            $this->auth->user(),
            $this->request->get('title'),
            $this->request->get('content'),
            $this->request->get('status'),
            $this->request->get('laravel_version'),
            $this->request->get('tags') ?: []
        );
        $article = $this->bus->execute($command);
        return $this->redirectAction('ArticlesController@getShow', $article->slug);
    }

    public function getUpdate($articleId)
    {
        $tags = $this->tagRepository->getAllForArticles();
        $versions = Laravel::$versions;
        $article = $this->articleRepository->requireById($articleId);

        $this->title = 'Update Article';
        $this->view('articles.update', compact('article', 'tags', 'versions'));
    }

    public function postUpdate($articleId)
    {
        $article = $this->articleRepository->requireById($articleId);

        $command = new Commands\UpdateArticleCommand(
            $article,
            $this->request->get('title'),
            $this->request->get('content'),
            $this->request->get('status'),
            $this->request->get('laravel_version'),
            $this->request->get('tags') ?: []
        );

        $article = $this->bus->execute($command);
        return $this->redirectAction('ArticlesController@getShow', $article->slug);
    }

    public function getDelete($articleId)
    {
        $article = $this->articleRepository->requireById($articleId);

        $this->title = "Delete Article";
        $this->view('articles.delete', compact('article'));
    }

    public function postDelete($articleId)
    {
        $article = $this->articleRepository->requireById($articleId);

        $command = new Commands\DeleteThreadCommand($article);
        $article = $this->bus->execute($command);

        return $this->redirectAction('ArticlesController@getIndex');
    }
}
