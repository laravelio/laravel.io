<?php namespace Lio\Forum\Threads\Commands;

use Lio\Accounts\Member;

class CreateThreadCommand
{
    public $subject;
    public $body;
    public $author;
    public $isQuestion;
    public $laravelVersion;
    public $tagIds;

    public function __construct($subject, $body, Member $author, $isQuestion, $laravelVersion, array $tagIds)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->author = $author;
        $this->isQuestion = $isQuestion;
        $this->laravelVersion = $laravelVersion;
        $this->tagIds = $tagIds;
    }
} 
