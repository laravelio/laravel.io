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
     * @var array
     */
    private $attributes;

    public function __construct(Thread $thread, array $attributes = [])
    {
        $this->thread = $thread;
        $this->attributes = array_only($attributes, ['subject', 'body', 'slug', 'topic', 'tags']);
    }

    public static function fromRequest(Thread $thread, ThreadRequest $request): self
    {
        return new static($thread, [
            'subject' => $request->subject(),
            'body' => $request->body(),
            'slug' => $request->subject(),
            'topic' => $request->topic(),
            'tags' => $request->tags(),
        ]);
    }

    public function handle(): Thread
    {
        $this->thread->update($this->attributes);

        if (array_has($this->attributes, 'topic')) {
            $this->thread->setTopic($this->attributes['topic']);
        }

        if (array_has($this->attributes, 'tags')) {
            $this->thread->syncTags($this->attributes['tags']);
        }

        $this->thread->save();

        return $this->thread;
    }
}
