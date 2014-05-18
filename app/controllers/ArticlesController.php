<?php

use Lio\Laravel\Laravel;
use Lio\Articles\Commands;
use Lio\Tags\TagRepository;
use Lio\CommandBus\CommandBus;
use Lio\Articles\EloquentArticleRepository;

use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Redirector;

class ArticlesController extends \BaseController
{
    private $bus;
    private $auth;
    private $request;
    private $redirector;
    private $tagRepository;
    private $articleRepository;

    public function __construct(EloquentArticleRepository $articleRepository, TagRepository $tagRepository, CommandBus $bus, Request $request, AuthManager $auth, Redirector $redirector)
    {
        $this->bus = $bus;
        $this->auth = $auth;
        $this->request = $request;
        $this->redirector = $redirector;
        $this->tagRepository = $tagRepository;
        $this->articleRepository = $articleRepository;
    }

    public function getIndex()
    {
        $tags = $this->tagRepository->getAllTagsBySlug($this->request->input('tags'));
        $articles = $this->articleRepository->getAllPublishedByTagsPaginated($tags);
        $this->title = 'Articles';
        $this->renderView('articles.index', compact('articles'));
    }

    public function getShow($articleSlug)
    {
        $article = $this->articleRepository->requireBySlug($articleSlug);
        $this->title = $article->title;
        $this->renderView('articles.show', compact('article'));
    }

    public function getCreate()
    {
        $tags = $this->tagRepository->getAllForForum();
        $versions = Laravel::$versions;
        $this->title = 'Create Forum Thread';
        $this->renderView('forum.threads.create', compact('tags', 'versions'));
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
        return $this->redirector->action('ArticlesController@getShow', [$article->slug]);
    }

    public function getUpdate($articleId)
    {
        $article = $this->articleRepository->requireById($articleId);
        $tags = $this->tagRepository->getAllForArticles();
        $versions = Laravel::$versions;
        $this->title = 'Update Article';
        $this->renderView('articles.update', compact('article', 'tags', 'versions'));
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
        return $this->redirector->action('ArticlesController@getShow', [$article->slug]);
    }

    public function getDelete($articleId)
    {
        $article = $this->articleRepository->requireById($articleId);
        $this->title = 'Delete Article';
        $this->renderView('articles.delete', compact('article'));
    }

    public function postDelete($articleId)
    {
        $article = $this->articleRepository->requireById($articleId);
        $command = new Commands\DeleteThreadCommand($article);
        $article = $this->bus->execute($command);
        return $this->redirector->action('ArticlesController@getShow', [$article->slug]);
    }
}
