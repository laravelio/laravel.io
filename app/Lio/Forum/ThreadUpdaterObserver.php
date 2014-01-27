<?php namespace Lio\Forum;

interface ThreadUpdaterObserver
{
    public function threadUpdateError($errors);
    public function threadUpdated($thread);
}