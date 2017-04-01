<?php

namespace App\Jobs;

use App\Http\Requests\ThreadRequest;
use App\Models\Thread;

class CreateThread
{
    /**
     * @var \App\Http\Requests\ThreadRequest
     */
    public $request;

    public function __construct(ThreadRequest $request)
    {
        $this->request = $request;
    }

    public function handle(): Thread
    {
        $thread = new Thread;
        $thread->subject = $this->request->subject();
        $thread->body = $this->request->body();
        $thread->authorRelation()->associate($this->request->author());
        $thread->topicRelation()->associate($this->request->topic());
        $thread->slug = $thread->generateUniqueSlug($this->request->subject());
        $thread->ip = $this->request->ip();
        $thread->save();

        if ($tags = $this->request->tags()) {
            $thread->tagsRelation()->sync($tags);
        }

        $thread->save();

        return $thread;
    }
}
