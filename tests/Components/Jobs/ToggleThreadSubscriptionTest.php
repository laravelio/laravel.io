<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Models\Thread;
use App\Jobs\ToggleThreadSubscription;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ToggleThreadSubscriptionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_toggle_the_user_thread_subscription()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create();

        $job = new ToggleThreadSubscription($thread, $user);

        $job->handle();
        $this->assertCount(1, $thread->subscribers()->get());

        $job->handle();
        $this->assertCount(0, $thread->subscribers()->get());
    }
}
