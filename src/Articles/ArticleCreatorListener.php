<?php namespace Lio\Articles;

interface ArticleCreatorListener
{
    public function articleCreationError($errors);
    public function articleCreated($reply);
}