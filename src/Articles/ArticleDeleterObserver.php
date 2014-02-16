<?php  namespace Lio\Articles; 

interface ArticleDeleterObserver
{
    public function onArticleDeleteSuccess(Article $article);
} 
