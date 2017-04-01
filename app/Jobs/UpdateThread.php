<?php

namespace App\Jobs;

use App\Http\Requests\ThreadRequest;
use App\Models\Thread;

class UpdateThread
{
    /**
     * @var \App\Models\Thread
     */
    private $thread;

    /**
     * @var \App\Http\Requests\ThreadRequest
     */
    public $request;

    public function __construct(Thread $thread, ThreadRequest $request)
    {
        $this->thread = $thread;
        $this->request = $request;
    }

    public function handle(): Thread
    {
        $this->thread->subject = $this->request->subject();
        $this->thread->body = $this->request->body();
        $this->thread->slug = $this->thread->generateUniqueSlug($this->thread->subject(), $this->thread->id());
        $this->thread->topicRelation()->associate($this->request->topic());
        $this->thread->tagsRelation()->sync($this->request->tags());
        $this->thread->save();

        return $this->thread;
    }
}
