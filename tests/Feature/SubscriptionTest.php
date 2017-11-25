<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Thread;
use App\Jobs\CreateReply;
use App\Models\Subscription;
use App\Notifications\NewReply;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscriptionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_receive_notifications_for_new_replies_to_threads_where_they_are_subscribed_to()
    {
        Notification::fake();

        $thread = factory(Thread::class)->create();
        [$author, $userOne, $userTwo] = factory(User::class)->times(3)->create();
        factory(Subscription::class)->create(['user_id' => $userOne->id(), 'subscriptionable_id' => $thread->id()]);
        factory(Subscription::class)->create(['user_id' => $userTwo->id(), 'subscriptionable_id' => $thread->id()]);

        $this->dispatch(new CreateReply('Foo', 'Bar', $author, $thread));

        Notification::assertSentTo([$userOne, $userTwo], NewReply::class);
    }
}
