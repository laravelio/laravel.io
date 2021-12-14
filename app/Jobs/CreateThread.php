<?php

namespace App\Jobs;

use App\Http\Requests\ThreadRequest;
use App\Models\Subscription;
use App\Models\Thread;
use App\Models\User;
use Ramsey\Uuid\Uuid;

final class CreateThread
{
    public function __construct(
        private string $subject,
        private string $body,
        private User $author,
        private array $tags = []
    ) {
    }

    public static function fromRequest(ThreadRequest $request): self
    {
        return new static(
            $request->subject(),
            $request->body(),
            $request->user(),
            $request->tags()
        );
    }

    public function handle(): Thread
    {
        $thread = new Thread([
            'subject' => $this->subject,
            'body' => $this->body,
            'slug' => $this->subject,
            'last_activity_at' => now(),
        ]);
        $thread->authoredBy($this->author);
        $thread->syncTags($this->tags);
        $thread->save();

        // Subscribe author to the thread.
        $subscription = new Subscription();
        $subscription->uuid = Uuid::uuid4()->toString();
        $subscription->userRelation()->associate($this->author);
        $subscription->subscriptionAbleRelation()->associate($thread);

        $thread->subscriptionsRelation()->save($subscription);

        return $thread;
    }
}
