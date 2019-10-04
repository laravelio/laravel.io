<?php

namespace App\Jobs;

use App\User;
use App\Models\Reply;
use Ramsey\Uuid\Uuid;
use App\Models\ReplyAble;
use App\Models\Subscription;
use App\Events\ReplyWasCreated;
use App\Models\SubscriptionAble;
use App\Http\Requests\CreateReplyRequest;

final class CreateReply
{
    /**
     * @var string
     */
    private $body;

    /**
     * @var \App\User
     */
    private $author;

    /**
     * @var \App\Models\ReplyAble
     */
    private $replyAble;

    public function __construct(string $body, User $author, ReplyAble $replyAble)
    {
        $this->body = $body;
        $this->author = $author;
        $this->replyAble = $replyAble;
    }

    public static function fromRequest(CreateReplyRequest $request): self
    {
        return new static($request->body(), $request->author(), $request->replyAble());
    }

    public function handle(): Reply
    {
        $reply = new Reply(['body' => $this->body]);
        $reply->authoredBy($this->author);
        $reply->to($this->replyAble);
        $reply->save();

        event(new ReplyWasCreated($reply));

        if ($this->replyAble instanceof SubscriptionAble && ! $this->replyAble->hasSubscriber($this->author)) {
            $subscription = new Subscription();
            $subscription->uuid = Uuid::uuid4()->toString();
            $subscription->userRelation()->associate($this->author);
            $subscription->subscriptionAbleRelation()->associate($this->replyAble);

            $this->replyAble->subscriptionsRelation()->save($subscription);
        }

        return $reply;
    }
}
