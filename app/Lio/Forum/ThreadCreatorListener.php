<?php namespace Lio\Forum;

interface ThreadCreatorListener
{
    public function threadCreationError($errors);
    public function threadCreated($thread);
}