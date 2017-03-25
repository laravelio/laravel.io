<?php

namespace App\Jobs;

use App\Forum\Thread;

class DeleteThread
{
    /**
     * @var \App\Users\User
     */
    public $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function handle()
    {
        $this->thread->tagsRelation()->detach();
        $this->thread->repliesRelation()->delete();
        $this->thread->delete();
    }
}
