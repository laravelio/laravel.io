<?php

namespace App\Http\Controllers;

use App\Jobs\UnsubscribeFromSubscriptionAble;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function unsubscribe(Subscription $subscription)
    {
        $thread = $subscription->subscriptionAble();

        $this->dispatch(new UnsubscribeFromSubscriptionAble($subscription->user(), $thread));

        $this->success("You're now unsubscribed from this thread.");

        return redirect()->route('thread', $thread->slug());
    }
}
