<?php  namespace Controllers\Articles;

use Lio\Articles\Article;
use Lio\Articles\ArticleDeleter;
use Lio\Articles\ArticleDeleterResponder;
use Lio\Articles\ArticleRepository;
use Auth;

class DeleteArticleController extends \BaseController implements ArticleDeleterResponder
{
    private $articles;
    private $deleter;

    public function __construct(ArticleRepository $articles, ArticleDeleter $deleter)
    {
        $this->articles = $articles;

        $deleter->setObserver($this);
        $this->deleter = $deleter;
    }

    public function getDelete($id)
    {
        $article = $this->articles->requireById($id);
        $this->view('articles.delete', compact('article'));
    }

    public function postDelete($id)
    {
        $article = $this->articles->requireById($id);
        if ( ! $article->isManageableBy(Auth::user())) {
            return $this->redirectTo('/');
        }
        return $this->deleter->delete($article);
    }

    public function onArticleDeleteSuccess(Article $article)
    {
        return $this->redirectAction('ArticlesController@getIndex', ['success' => 'You have successfully deleted the post titled, "'.$article->title.'."']);
    }
} 
