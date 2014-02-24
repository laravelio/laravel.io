<?php  namespace Controllers\Articles; 

use Lio\Articles\Article;
use Lio\Articles\ArticleRepository;
use Lio\Articles\ArticleUpdater;
use Lio\Articles\ArticleForm;
use Lio\Articles\ArticleUpdaterResponder;
use Lio\Tags\TagRepository;
use Auth, Input;

class UpdateArticleController extends \BaseController implements ArticleUpdaterResponder
{
    private $articles;
    private $updater;
    private $tags;

    public function __construct(ArticleRepository $articles, ArticleUpdater $updater, TagRepository $tags)
    {
        $updater->setObserver($this);
        $this->updater = $updater;

        $this->tags = $tags;
        $this->articles = $articles;
    }
    
    public function getUpdate($id)
    {
        $article = $this->articles->requireById($id);
        if ( ! $article->isOwnedBy(Auth::user())) {
            return Redirect::to('/');
        }
        $tags = $this->tags->getAllForArticles();
        $this->view('articles.update', compact('article', 'tags'));
    }

    public function postUpdate($id)
    {
        $article = $this->articles->requireById($id);
        if ( ! $article->isOwnedBy(Auth::user())) {
            return Redirect::to('/');
        }
        $data = Input::only('title', 'content', 'laravel_version', 'status');
        return $this->updater->update($article, $data, Input::get('tags'), new ArticleForm);
    }

    public function onArticleUpdateFailure($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function onArticleUpdateSuccess(Article $article)
    {
        if ($article->isPublished()) {
            return $this->redirectAction('Controllers\Articles\ShowArticleController@getShow', [$article->slug]);
        }

        return $this->redirectAction('Controllers\Articles\UpdateArticleController@getUpdate', [$article->id]);
    }

}
