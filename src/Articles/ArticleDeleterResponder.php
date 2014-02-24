<?php  namespace Lio\Articles; 

interface ArticleDeleterResponder
{
    public function onArticleDeleteSuccess(Article $article);
} 
