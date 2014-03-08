<?php namespace Lio\Forum; 

use Lio\Accounts\User;
use Lio\Core\EventGenerator;
use Lio\Forum\Threads\Events\ThreadCreatedEvent;
use Lio\Forum\Threads\Thread;
use Lio\Forum\Threads\ThreadRepository;

class Forum
{
    use EventGenerator;

    /**
     * @var Threads\ThreadRepository
     */
    private $threads;

    public function __construct(ThreadRepository $threads)
    {
        $this->threads = $threads;
    }

    public function addThread($subject, $body, User $author, $isQuestion, $laravelVersion, array $tagIds)
    {
        $thread = new Thread([
            'subject' => $subject,
            'body' => $body,
            'author_id' => $author->id,
            'is_question' => $isQuestion,
            'laravel_version' => $laravelVersion,
        ]);

        $thread->setTagsById($tagIds);

        $this->raise(new ThreadCreatedEvent($thread));

        return $thread;
    }
} 
