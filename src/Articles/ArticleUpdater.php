<?php  namespace Lio\Articles; 

class ArticleUpdater
{
    private $articles;
    private $observer;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    public function setObserver(ArticleUpdaterResponder $observer)
    {
        $this->observer = $observer;
    }

    public function update(Article $article, array $data, array $tagIds)
    {
        $article->fill($data);

        if ( ! $this->articles->save($article)) {
            return $this->failure($article->getErrors());
        }

        if ($tagIds) {
            $article->setTags($tagIds);
        }

        if ($this->needToPublish($data)) {
            $article->publish();
        } elseif ($this->needsToBeSetAsDraft($data)) {
            $article->setDraft();
        }

        return $this->success($article);
    }

    private function failure($errors)
    {
        if ($this->observer) {
            return $this->observer->onArticleUpdateFailure($errors);
        }
    }

    private function success(Article $article)
    {
        if ($this->observer) {
            return $this->observer->onArticleUpdateSuccess($article);
        }
    }

    private function needToPublish($data)
    {
        return isset($data['status']) && $data['status'] == Article::STATUS_PUBLISHED;
    }

    private function needsToBeSetAsDraft($data)
    {
        return ! isset($data['status']) || $data['status'] == 0;
    }
} 
