<?php

namespace App\Jobs;

use App\Http\Requests\ThreadRequest;
use App\Models\Thread;
use Illuminate\Support\Arr;

final class UpdateThread
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
        $this->attributes = Arr::only($attributes, ['subject', 'body', 'slug', 'tags']);
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

        if (Arr::has($this->attributes, 'tags')) {
            $this->thread->syncTags($this->attributes['tags']);
        }

        $this->thread->save();

        return $this->thread;
    }
}
