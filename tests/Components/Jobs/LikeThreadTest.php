<?php

namespace Tests\Components\Jobs;

use App\Exceptions\CannotLikeThreadMultipleTimes;
use App\Jobs\LikeThread;
use App\Models\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LikeThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_like_a_thread()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();

        $this->dispatch(new LikeThread($thread, $user));

        $this->assertTrue($thread->fresh()->isLikedBy($user));
    }

    /** @test */
    public function we_cannot_like_a_thread_twice()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();

        $this->dispatch(new LikeThread($thread, $user));

        $this->assertTrue($thread->fresh()->isLikedBy($user));

        $this->expectException(CannotLikeThreadMultipleTimes::class);

        $this->dispatch(new LikeThread($thread, $user));
    }
}
