<?php namespace Lio\Forum;

use Lio\Accounts\Member;
use Lio\Events\EventGenerator;
use Lio\Forum\Replies;
use Lio\Forum\Threads;

class Forum
{
    use \Lio\Events\EventGenerator;

    private $threads;

    public function __construct(Threads\ThreadRepository $threads)
    {
        $this->threads = $threads;
    }

    public function addThread($subject, $body, Member $author, $isQuestion, $laravelVersion, array $tagIds)
    {
        $thread = new Threads\Thread([
            'subject' => $subject,
            'body' => $body,
            'author_id' => $author->id,
            'is_question' => $isQuestion,
            'laravel_version' => $laravelVersion,
        ]);

        $thread->setTagsById($tagIds);

        $this->raise(new Threads\Events\ThreadCreatedEvent($thread));

        return $thread;
    }

    public function UpdateThread(Threads\Thread $thread, $subject, $body, Member $author, $isQuestion, $laravelVersion, array $tagIds)
    {
        $thread->fill([
            'subject' => $subject,
            'body' => $body,
            'author_id' => $author->id,
            'is_question' => $isQuestion,
            'laravel_version' => $laravelVersion,
        ]);

        $thread->setTagsById($tagIds);

        $this->raise(new Threads\Events\ThreadUpdatedEvent($thread));

        return $thread;
    }

    public function markThreadSolved(Threads\Thread $thread, Replies\Reply $solution)
    {
        $thread->solution_reply_id = $solution->id;
        $this->raise(new Threads\Events\ThreadSolvedEvent($thread, $solution));
        return $thread;
    }

    public function markThreadUnsolved(Threads\Thread $thread)
    {
        $thread->solution_reply_id = null;
        $this->raise(new Threads\Events\ThreadUnsolvedEvent($thread));
        return $thread;
    }

    public function deleteThread(Threads\Thread $thread)
    {
        $this->raise(new Threads\Events\ThreadDeletedEvent($thread));
        return $thread;
    }

    public function addThreadReply(Threads\Thread $thread, $body, Member $author)
    {
        $reply = new Replies\Reply([
            'body' => $body,
            'thread_id' => $thread->id,
            'author_id' => $author->id,
        ]);

        $this->raise(new Replies\Events\ReplyCreatedEvent($reply));

        return $reply;
    }

    public function updateThreadReply(Replies\Reply $reply, $body)
    {
        $reply->fill([
            'body' => $body,
        ]);

        $this->raise(new Replies\Events\ReplyUpdatedEvent($reply));

        return $reply;
    }

    public function deleteThreadReply(Replies\Reply $reply)
    {
        $this->raise(new Replies\Events\ReplyDeletedEvent($reply));
        return $reply;
    }
}
