<?php

namespace App\Jobs;

use App\Http\Requests\ThreadRequest;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Arr;

final class UpdateThread
{
    /**
     * @var Thread
     */
    private $thread;

    /**
     * @var User
     */
    private $updatedBy;

    /**
     * @var array
     */
    private $attributes;

    public function __construct(Thread $thread, User $updatedBy, array $attributes = [])
    {
        $this->thread = $thread;
        $this->updatedBy = $updatedBy;
        $this->attributes = Arr::only($attributes, ['subject', 'body', 'slug', 'tags']);
    }

    public static function fromRequest(Thread $thread, ThreadRequest $request): self
    {
        return new static($thread, $request->user(), [
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

        $this->thread->updatedByRelation()->associate($this->updatedBy);

        $this->thread->save();

        return $this->thread;
    }
}
