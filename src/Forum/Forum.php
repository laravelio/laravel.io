<?php namespace Lio\Forum; 

use Lio\Accounts\User;
use Lio\Core\EventGenerator;
use Lio\Forum\Replies\Reply;
use Lio\Forum\Threads\Events;
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

        $this->raise(new Events\ThreadCreatedEvent($thread));

        return $thread;
    }

    public function UpdateThread(Thread $thread, $subject, $body, User $author, $isQuestion, $laravelVersion, array $tagIds)
    {
        $thread->fill([
            'subject' => $subject,
            'body' => $body,
            'author_id' => $author->id,
            'is_question' => $isQuestion,
            'laravel_version' => $laravelVersion,
        ]);

        $thread->setTagsById($tagIds);

        $this->raise(new Events\ThreadUpdatedEvent($thread));

        return $thread;
    }

    public function markThreadSolved(Thread $thread, Reply $solution)
    {
        $thread->solution_reply_id = $solution->id;
        $this->raise(new Events\ThreadSolvedEvent($thread, $solution));
        return $thread;
    }

    public function markThreadUnsolved(Thread $thread)
    {
        $thread->solution_reply_id = null;
        $this->raise(new Events\ThreadUnsolvedEvent($thread));
        return $thread;
    }

    public function deleteThread(Thread $thread)
    {
        $this->raise(new Events\ThreadDeletedEvent($thread));
        return $thread;
    }
}
