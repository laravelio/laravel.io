<?php

namespace App\Jobs;

use App\Models\Subscription;
use App\User;
use App\Models\Thread;
use App\Http\Requests\ThreadRequest;

final class CreateThread
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var \App\User
     */
    private $author;

    /**
     * @var array
     */
    private $tags;

    public function __construct(string $subject, string $body, string $ip, User $author, array $tags = [])
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->ip = $ip;
        $this->author = $author;
        $this->tags = $tags;
    }

    public static function fromRequest(ThreadRequest $request): self
    {
        return new static(
            $request->subject(),
            $request->body(),
            $request->ip(),
            $request->author(),
            $request->tags()
        );
    }

    public function handle(): Thread
    {
        $thread = new Thread([
            'subject' => $this->subject,
            'body' => $this->body,
            'ip' => $this->ip,
            'slug' => $this->subject,
        ]);
        $thread->authoredBy($this->author);
        $thread->syncTags($this->tags);
        $thread->save();

        // Subscribe author to the thread.
        $subscription = new Subscription();
        $subscription->userRelation()->associate($this->author);
        $subscription->subscriptionAbleRelation()->associate($thread);

        $thread->subscriptionsRelation()->save($subscription);

        return $thread;
    }
}
