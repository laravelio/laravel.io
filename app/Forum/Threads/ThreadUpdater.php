<?php

namespace Lio\Forum\Threads;

/**
 * This class can call the following methods on the observer object:.
 *
 * threadUpdateError($errors)
 * threadpdated($thread)
 */
class ThreadUpdater
{
    protected $threads;

    public function __construct(ThreadRepository $threads)
    {
        $this->threads = $threads;
    }

    public function update(ThreadUpdaterListener $observer, $thread, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && !$validator->isValid()) {
            return $observer->threadUpdateError($validator->getErrors());
        }

        return $this->updateRecord($thread, $observer, $data);
    }

    private function updateRecord($thread, $observer, $data)
    {
        $thread->fill($data);

        // check the model validation
        if (!$this->threads->save($thread)) {
            return $observer->threadUpdateError($thread->getErrors());
        }

        if (isset($data['tags'])) {
            $this->attachTags($thread, $data['tags']);
        }

        return $observer->threadUpdated($thread);
    }

    private function attachTags($thread, $tags)
    {
        $thread->tags()->sync($tags);
    }
}
