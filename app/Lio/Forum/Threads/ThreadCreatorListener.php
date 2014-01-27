<?php namespace Lio\Forum\Threads;

interface ThreadCreatorListener
{
    public function threadCreationError($errors);
    public function threadCreated($thread);
}