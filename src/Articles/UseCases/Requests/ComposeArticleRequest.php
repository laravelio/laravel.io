<?php namespace Lio\Articles\UseCases\Requests;

class ComposeArticleRequest
{
    public $author;
    public $title;
    public $content;
    public $status;
    public $laravelVersion;
    public $tagIds;

    public function __construct($author, $title, $content, $status, $laravelVersion, array $tagIds = [])
    {
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->status = $status;
        $this->laravelVersion = $laravelVersion;
        $this->tagIds = $tagIds;
    }
}
