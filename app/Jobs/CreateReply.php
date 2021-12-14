<?php

namespace App\Jobs;

use App\Events\ReplyWasCreated;
use App\Http\Requests\CreateReplyRequest;
use App\Models\Reply;
use App\Models\ReplyAble;
use App\Models\Subscription;
use App\Models\SubscriptionAble;
use App\Models\User;
use Ramsey\Uuid\Uuid;

final class CreateReply
{
    public function __construct(
        private string $body,
        private User $author,
        private ReplyAble $replyAble
    ) {
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
