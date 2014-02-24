<?php namespace Lio\Forum\Threads;

interface ThreadUpdaterResponder
{
    public function threadUpdateError($errors);
    public function threadUpdated($thread);
}
