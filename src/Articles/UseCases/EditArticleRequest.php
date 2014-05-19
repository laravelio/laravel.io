<?php namespace Lio\Articles\UseCases;

class EditArticleRequest
{
    public $articleId;
    public $title;
    public $content;
    public $tagIds;

    public function __construct($articleId, $title, $content, array $tagIds = [])
    {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->content = $content;
        $this->tagIds = $tagIds;
    }
}
