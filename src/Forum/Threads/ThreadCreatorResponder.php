<?php namespace Lio\Forum\Threads;

interface ThreadCreatorResponder
{
    public function threadCreationError($errors);
    public function threadCreated($thread);
}
