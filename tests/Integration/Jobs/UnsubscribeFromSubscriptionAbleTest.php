<?php

namespace Tests\Integration\Jobs;

use App\Jobs\UnsubscribeFromSubscriptionAble;
use App\Models\Subscription;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnsubscribeFromSubscriptionAbleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_unsubscribe_a_user_from_a_thread()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create();
        factory(Subscription::class)->create(['user_id' => $user->id(), 'subscriptionable_id' => $thread->id()]);

        $this->assertTrue($thread->hasSubscriber($user));

        $this->dispatch(new UnsubscribeFromSubscriptionAble($user, $thread));

        $this->assertFalse($thread->hasSubscriber($user));
    }
}
