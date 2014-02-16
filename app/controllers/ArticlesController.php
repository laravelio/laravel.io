<?php

use Lio\Comments\Comment;
use Lio\Tags\TagRepository;
use Lio\Articles\ArticleRepository;

class ArticlesController extends BaseController
{
    private $articles;
    private $tags;

    private $articlesPerPage = 20;

    public function __construct(ArticleRepository $articles, TagRepository $tags)
    {
        $this->tags     = $tags;
        $this->articles = $articles;
    }

    public function getDashboard()
    {
        $articles = $this->articles->getArticlesByAuthorPaginated(Auth::user());
        $this->view('articles.dashboard', compact('articles'));
    }

    public function getCompose()
    {
        $tags = $this->tags->getAllForArticles();
        $versions = \Lio\Comments\Comment::$laravelVersions;
        $this->view('articles.compose', compact('tags', 'versions'));
    }

    public function postCompose()
    {
        $form = $this->articles->getArticleForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $article = $this->articles->getNew(Input::only('title', 'content', 'status', 'laravel_version'));
        $article->author_id = Auth::user()->id;

        if ( ! $article->isValid()) {
            return $this->redirectBack(['errors' => $article->getErrors()]);
        }

        $this->articles->save($article);

        // store tags
        $tags = $this->tags->getTagsByIds(Input::get('tags'));
        $article->tags()->sync($tags->lists('id'));

        if ($article->isPublished()) {
            return $this->redirectAction('ArticlesController@getShow', [$id]);
        } else {
            return $this->redirectAction('ArticlesController@getDashboard');
        }
    }

    public function getEdit($id)
    {
        $article = $this->articles->requireById($id);
        $tags = $this->tags->getAllForArticles();
        $versions = \Lio\Comments\Comment::$laravelVersions;

        $this->view('articles.edit', compact('article', 'tags', 'versions'));
    }

    public function postEdit($id)
    {
        $article = $this->articles->requireById($id);

        $form = $this->articles->getArticleForm();

        if ( ! $form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $article->fill(Input::only('title', 'content', 'status', 'laravel_version'));

        if ( ! $article->isValid()) {
            return $this->redirectBack(['errors' => $article->getErrors()]);
        }

        $this->articles->save($article);

        // store tags
        $tags = $this->tags->getTagsByIds(Input::get('tags'));
        $article->tags()->sync($tags->lists('id'));


        if ($article->isPublished()) {
            return $this->redirectAction('ArticlesController@getShow', [$id]);
        } else {
            return $this->redirectAction('ArticlesController@getDashboard');
        }
    }

    public function getEditComment($articleSlug, $commentId)
    {
        $article = App::make('SlugModel');
        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $this->view('articles.editcomment', compact('comment'));
    }

    public function postEditComment($id, $commentId)
    {
        // i hate everything about these controllers, it's awful
        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');

        $form = new \Lio\Comments\ReplyForm;

        if ( ! $form->isValid()) return $this->redirectBack(['errors' => $form->getErrors()]);

        $comment->fill([
            'body' => Input::get('body'),
        ]);

        if ( ! $comment->isValid()) return $this->redirectBack(['errors' => $comment->getErrors()]);

        $this->comments->save($comment);

        return $this->redirectAction('ArticlesController@getShow', [$id]);
    }

    public function getDeleteComment($id, $commentId)
    {
        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $this->view('articles.deletecomment', compact('comment'));
    }

    public function postDeleteComment($id, $commentId)
    {
        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $comment->delete();

        return Redirect::action('ArticlesController@getShow', [$id]);
    }

    public function getSearch()
    {
        $query = Input::get('query');
        $results = App::make('Lio\Articles\ArticleSearch')->searchPaginated($query, $this->articlesPerPage);
        $this->view('articles.search', compact('query', 'results'));
    }
}
