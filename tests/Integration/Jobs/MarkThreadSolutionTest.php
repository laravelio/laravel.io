<?php

namespace Tests\Integration\Jobs;

use App\Jobs\MarkThreadSolution;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkThreadSolutionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_mark_thread_solution()
    {
        $user = $this->login();
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create();

        $this->dispatch(new MarkThreadSolution($thread, $reply));

        $this->assertTrue($thread->isSolutionReply($reply));
        $this->assertTrue($thread->isSolutionSelector($user));
    }
}
