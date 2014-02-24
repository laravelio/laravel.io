<?php namespace Lio\Articles;

interface ArticleUpdaterResponder
{
    public function onArticleUpdateFailure($errors);
    public function onArticleUpdateSuccess(Article $article);
}
