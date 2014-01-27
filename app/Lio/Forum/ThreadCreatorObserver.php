<?php namespace Lio\Forum;

interface ThreadCreatorObserver
{
    public function threadCreationError($errors);
    public function threadCreated($thread);
}