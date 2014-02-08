<?php namespace Lio\Forum\Threads;

/**
* This class can call the following methods on the observer object:
*
* threadDeleted()
*/
class ThreadDeleter
{
    protected $threads;

    public function __construct(ThreadRepository $threads)
    {
        $this->threads = $threads;
    }

    public function delete(ThreadDeleterListener $observer, $thread)
    {
        $this->deleteReplies($thread);

        $this->threads->delete($thread);
        return $observer->threadDeleted();
    }

    private function deleteReplies(Thread $thread)
    {
        $thread->replies()->delete();
    }
}
