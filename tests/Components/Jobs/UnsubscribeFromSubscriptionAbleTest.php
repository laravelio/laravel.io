<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Models\Thread;
use App\Models\Subscription;
use App\Jobs\UnsubscribeFromSubscriptionAble;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
