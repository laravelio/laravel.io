<?php namespace Lio\Articles;

interface ArticleUpdaterObserver
{
    public function onArticleUpdateFailure($errors);
    public function onArticleUpdateSuccess(Article $article);
}
