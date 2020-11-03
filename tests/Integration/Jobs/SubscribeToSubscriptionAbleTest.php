<?php

namespace Tests\Integration\Jobs;

use App\Jobs\SubscribeToSubscriptionAble;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeToSubscriptionAbleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_subscribe_a_user_to_a_thread()
    {
        $user = $this->createUser();
        $thread = Thread::factory()->create();

        $this->assertFalse($thread->hasSubscriber($user));

        $this->dispatch(new SubscribeToSubscriptionAble($user, $thread));

        $this->assertTrue($thread->hasSubscriber($user));
    }
}
