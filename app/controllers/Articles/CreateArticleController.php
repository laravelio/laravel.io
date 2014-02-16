<?php namespace Controllers\Articles;

use Lio\Articles\ArticleCreator;
use Lio\Articles\ArticleCreatorObserver;
use Lio\Articles\ArticleForm;
use Lio\Tags\TagRepository;
use Auth, Input;

class CreateArticleController extends \BaseController implements ArticleCreatorObserver
{
    private $creator;
    private $tags;

    public function __construct(ArticleCreator $creator, TagRepository $tags)
    {
        $creator->setObserver($this);
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
        $data = Input::only('title', 'content', 'laravel_version', 'status');
        return $this->creator->create($data, Auth::user(), Input::get('tags'), new ArticleForm);
    }

    public function articleCreationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function articleCreated($article)
    {
        if ($article->isPublished()) {
            return $this->redirectAction('Controllers\Articles\ShowArticleController@getShow', [$article->slug]);
        }

        return $this->redirectAction('Controllers\Articles\UpdateArticleController@getUpdate', [$article->id]);
    }
}
