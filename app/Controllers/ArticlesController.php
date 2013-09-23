<?php namespace Controllers;

use Lio\Articles\ArticleRepository;
use Lio\Tags\TagRepository;
use App, Auth, Input;

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
        $tags     = $this->tags->getAllTagsBySlug(Input::get('tags'));
        $articles = $this->articles->getAllPublishedByTagsPaginated($tags);

        $this->view('articles.index', compact('articles'));
    }

    public function getShow()
    {
        $article = App::make('slugModel');
        dd($article);
    }

    public function getDashboard()
    {
        $articles = $this->articles->getArticlesByAuthorPaginated(Auth::user());

        $this->view('articles.dashboard', compact('articles'));
    }

    public function getCompose()
    {
        $tags = $this->tags->getAll();

        $this->view('articles.compose', compact('tags'));
    }

    public function postCompose()
    {
        $form = $this->articles->getArticleForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $article = $this->articles->getNew(Input::only('title', 'content', 'status'));
        $article->author_id = Auth::user()->id;

        if ( ! $article->isValid()) {
            return $this->redirectBack(['errors' => $article->getErrors()]);
        }

        $this->articles->save($article);

        $article->tags = Input::get('tags');

        $articleSlug = $article->slug()->first();

        if ($article->isPublished()) {
            return $this->redirectAction('Controllers\ArticlesController@getShow', [$articleSlug]);
        } else {
            return $this->redirectAction('Controllers\ArticlesController@getDashboard');
        }
    }

    public function getEdit($articleId)
    {
        $article = $this->articles->requireById($articleId);
        $tags    = $this->tags->getAll();

        $this->view('articles.edit', compact('article', 'tags'));
    }

    public function postEdit($articleId)
    {
        $article = $this->articles->requireById($articleId);

        $form = $this->articles->getArticleForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $article->fill(Input::only('title', 'content', 'status'));

        if ( ! $article->isValid()) {
            return $this->redirectBack(['errors' => $article->getErrors()]);
        }

        $this->articles->save($article);

        $article->tags = Input::get('tags');

        $articleSlug = $article->slug()->first();

        if ($article->isPublished()) {
            return $this->redirectAction('Controllers\ArticlesController@getShow', [$articleSlug->slug]);
        } else {
            return $this->redirectAction('Controllers\ArticlesController@getDashboard');
        }
    }
}