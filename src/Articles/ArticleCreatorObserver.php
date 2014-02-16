<?php namespace Lio\Articles;

interface ArticleCreatorObserver
{
    public function articleCreationError($errors);
    public function articleCreated($article);
}
