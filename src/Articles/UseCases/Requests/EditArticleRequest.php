<?php namespace Lio\Articles\UseCases\Requests;

class EditArticleRequest
{
    private $articleId;
    private $title;
    private $content;
    private $laravelVersion;
    private $tagIds;

    public function __construct($articleId, $title, $content, $laravelVersion, array $tagIds = [])
    {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->content = $content;
        $this->laravelVersion = $laravelVersion;
        $this->tagIds = $tagIds;
    }
}
