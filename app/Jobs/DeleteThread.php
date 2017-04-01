<?php

namespace App\Jobs;

use App\Models\Thread;

class DeleteThread
{
    /**
     * @var \App\User
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
