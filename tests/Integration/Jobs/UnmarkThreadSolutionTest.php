<?php

namespace Tests\Integration\Jobs;

use App\Jobs\UnmarkThreadSolution;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnmarkThreadSolutionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_unmark_thread_solution()
    {
        $user = $this->login();
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create();

        $thread->markSolution($reply, $user);
        $this->assertTrue($thread->isSolutionReply($reply));
        $this->assertTrue($thread->wasAnsweredBy($user));

        $this->dispatch(new UnmarkThreadSolution($thread));

        $this->assertFalse($thread->isSolutionReply($reply));
        $this->assertFalse($thread->fresh()->wasAnsweredBy($user));
    }
}
