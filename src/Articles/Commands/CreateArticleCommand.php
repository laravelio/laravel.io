<?php namespace Lio\Articles\Commands;

class CreateArticleCommand
{
    public $title;
    public $content;
    public $status;
    public $laravelVersion;
    public $tagIds;
    /**
     * @var User
     */
    public $author;

    public function __construct(User $author, $title, $content, $status, $laravelVersion, array $tagIds = [])
    {
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->status = $status;
        $this->laravelVersion = $laravelVersion;
        $this->tagIds = $tagIds;
    }
} 
