<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Models\Thread;
use App\Jobs\SubscribeToSubscriptionAble;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToSubscriptionAbleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_subscribe_a_user_to_a_thread()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create();

        $this->assertFalse($thread->hasSubscriber($user));

        $this->dispatch(new SubscribeToSubscriptionAble($user, $thread));

        $this->assertTrue($thread->hasSubscriber($user));
    }
}
