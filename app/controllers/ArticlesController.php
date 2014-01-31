<?php

use Lio\Articles\ArticleRepository;
use Lio\Tags\TagRepository;
use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

class ArticlesController extends BaseController
{
    private $articles;
    private $tags;
    private $comments;

    private $articlesPerPage = 20;
    private $commentsPerPage = 20;

    public function __construct(ArticleRepository $articles, TagRepository $tags, CommentRepository $comments)
    {
        $this->tags     = $tags;
        $this->articles = $articles;
        $this->comments = $comments;
    }

    public function getIndex()
    {
        $tags     = $this->tags->getAllTagsBySlug(Input::get('tags'));
        $articles = $this->articles->getAllPublishedByTagsPaginated($tags);

        $this->view('articles.index', compact('articles'));
    }

    public function getShow()
    {
        $article = App::make('SlugModel');
        $comments = $this->comments->getArticleCommentsPaginated($article, $this->commentsPerPage);

        $this->view('articles.show', compact('article', 'comments'));
    }

    public function postShow()
    {
        $article = App::make('SlugModel');

        $form = new \Lio\Comments\ReplyForm;

        if ( ! $form->isValid()) return $this->redirectBack(['errors' => $form->getErrors()]);

        $comment = $this->comments->getNew([
            'body'      => Input::get('body'),
            'author_id' => Auth::user()->id,
            'type'      => Comment::TYPE_ARTICLE,
        ]);

        if ( ! $comment->isValid()) return $this->redirectBack(['errors' => $comment->getErrors()]);

        $article->comments()->save($comment);

        return $this->redirectAction('ArticlesController@getShow', [$article->slug->slug]);
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
            $articleSlug = $article->slug()->first();
            return $this->redirectAction('ArticlesController@getShow', [$articleSlug->slug]);
        } else {
            return $this->redirectAction('ArticlesController@getDashboard');
        }
    }

    public function getEdit($articleId)
    {
        $article = $this->articles->requireById($articleId);
        $tags = $this->tags->getAllForArticles();
        $versions = \Lio\Comments\Comment::$laravelVersions;

        $this->view('articles.edit', compact('article', 'tags', 'versions'));
    }

    public function postEdit($articleId)
    {
        $article = $this->articles->requireById($articleId);

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
            $articleSlug = $article->slug()->first();
            return $this->redirectAction('ArticlesController@getShow', [$articleSlug->slug]);
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

    public function postEditComment($articleSlug, $commentId)
    {
        $article = App::make('SlugModel');

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

        return $this->redirectAction('ArticlesController@getShow', [$article->slug->slug]);
    }

    public function getDeleteComment($articleSlug, $commentId)
    {
        $article = App::make('SlugModel');

        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $this->view('articles.deletecomment', compact('comment'));
    }

    public function postDeleteComment($articleSlug, $commentId)
    {
        $article = App::make('SlugModel');

        $comment = $this->comments->requireById($commentId);
        if (Auth::user()->id != $comment->author_id) return Redirect::to('/');
        $comment->delete();

        return Redirect::action('ArticlesController@getShow', [$article->slug->slug]);
    }

    public function getSearch()
    {
        $query = Input::get('query');
        $results = App::make('Lio\Articles\ArticleSearch')->searchPaginated($query, $this->articlesPerPage);
        $this->view('articles.search', compact('query', 'results'));
    }
}