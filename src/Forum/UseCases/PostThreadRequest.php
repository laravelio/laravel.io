<?php namespace Lio\Forum\UseCases; 

use Lio\Accounts\Member;

class PostThreadRequest
{
    public $member;
    public $subject;
    public $body;
    public $isQuestion;
    public $laravelVersion;
    public $tagIds;

    public function __construct(Member $member, $subject, $body, $isQuestion, $laravelVersion, array $tagIds = [])
    {
        $this->member = $member;
        $this->subject = $subject;
        $this->body = $body;
        $this->isQuestion = $isQuestion;
        $this->laravelVersion = $laravelVersion;
        $this->tagIds = $tagIds;
    }
} 
