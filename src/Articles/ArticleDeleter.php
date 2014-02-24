<?php  namespace Lio\Articles; 

class ArticleDeleter
{
    private $articles;
    private $observer;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    public function setObserver(ArticleDeleterResponder $observer)
    {
        $this->observer = $observer;
    }

    public function delete(Article $article)
    {
        $article->delete();
        return $this->success($article);
    }

    private function success(Article $article)
    {
        if ($this->observer) {
            return $this->observer->onArticleDeleteSuccess($article);
        }
    }
} 
