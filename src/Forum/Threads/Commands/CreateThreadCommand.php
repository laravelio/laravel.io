<?php namespace Lio\Forum\Threads\Commands; 

use Lio\Accounts\User;

class CreateThreadCommand
{
    public $subject;
    public $body;
    public $author;
    public $isQuestion;
    public $laravelVersion;
    public $tagIds;

    public function __construct($subject, $body, User $author, $isQuestion, $laravelVersion, array $tagIds)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->author = $author;
        $this->isQuestion = $isQuestion;
        $this->laravelVersion = $laravelVersion;
        $this->tagIds = $tagIds;
    }
} 
