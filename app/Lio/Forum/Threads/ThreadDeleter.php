<?php namespace Lio\Forum\Threads;

use Lio\Forum\SectionCountManager;

/**
* This class can call the following methods on the observer object:
*
* threadDeleted()
*/
class ThreadDeleter
{
    protected $threads;
    protected $countManager;

    public function __construct(ThreadRepository $threads, SectionCountManager $countManager)
    {
        $this->threads = $threads;
        $this->countManager = $countManager;
    }

    public function delete(ThreadDeleterListener $observer, $thread)
    {
        $this->deleteReplies($thread);

        $this->threads->delete($thread);
        $this->countManager->cacheSections();
        return $observer->threadDeleted();
    }

    private function deleteReplies(Thread $thread)
    {
        $thread->replies()->delete();
    }
}