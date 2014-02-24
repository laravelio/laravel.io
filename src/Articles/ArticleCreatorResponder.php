<?php namespace Lio\Articles;

interface ArticleCreatorResponder
{
    public function articleCreationError($errors);
    public function articleCreated($article);
}
