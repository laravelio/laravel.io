<?php namespace Lio\Forum;

interface ThreadUpdaterListener
{
    public function threadUpdateError($errors);
    public function threadUpdated($thread);
}