<?php

namespace App\Jobs;

use App\Events\ThreadWasCreated;
use App\Http\Requests\ThreadRequest;
use App\Models\Subscription;
use App\Models\Thread;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class CreateThread
{
    public function __construct(
        private UuidInterface $uuid,
        private string $subject,
        private string $body,
        private User $author,
        private array $tags = []
    ) {
    }

    public static function fromRequest(ThreadRequest $request, UuidInterface $uuid): self
    {
        return new static(
            $uuid,
            $request->subject(),
            $request->body(),
            $request->user(),
            $request->tags(),
        );
    }

    public function handle(): void
    {
        $thread = new Thread([
            'uuid' => $this->uuid->toString(),
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

        event(new ThreadWasCreated($thread));
    }
}
