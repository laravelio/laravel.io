<?php namespace Lio\Forum; 

use Lio\Accounts\User;
use Lio\Core\EventGenerator;
use Lio\Forum\Threads\Events\ThreadCreatedEvent;
use Lio\Forum\Threads\Thread;

class Forum
{
    use EventGenerator;

    public function addThread($subject, $body, User $author, $isQuestion, $laravelVersion, array $tagIds)
    {
        $thread = new Thread([
            'subject' => $subject,
            'body' => $body,
            'author_id' => $author->id,
            'is_question' => $isQuestion,
            'laravel_version' => $laravelVersion,
        ]);

        $this->raise(new ThreadCreatedEvent($thread, $tagIds));

        return $thread;
    }
} 
