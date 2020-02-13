<?php

namespace Tests\Integration\Jobs;

use App\Jobs\UnlikeThread;
use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnlikeThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_unlike_a_thread()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();

        $thread->likedBy($user);
        $this->assertTrue($thread->fresh()->isLikedBy($user));

        $this->dispatch(new UnlikeThread($thread, $user));

        $this->assertFalse($thread->fresh()->isLikedBy($user));
    }
}
