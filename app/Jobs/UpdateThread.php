<?php

namespace App\Jobs;

use App\Models\Thread;
use App\Http\Requests\ThreadRequest;

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
        $this->attributes = array_only($attributes, ['subject', 'body', 'slug', 'tags']);
    }

    public static function fromRequest(Thread $thread, ThreadRequest $request): self
    {
        return new static($thread, [
            'subject' => $request->subject(),
            'body' => $request->body(),
            'slug' => $request->subject(),
            'tags' => $request->tags(),
        ]);
    }

    public function handle(): Thread
    {
        $this->thread->update($this->attributes);

        if (array_has($this->attributes, 'tags')) {
            $this->thread->syncTags($this->attributes['tags']);
        }

        $this->thread->save();

        return $this->thread;
    }
}
