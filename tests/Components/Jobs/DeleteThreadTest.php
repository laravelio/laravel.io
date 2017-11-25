<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use App\Jobs\DeleteThread;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_delete_a_thread_and_its_replies()
    {
        $thread = factory(Thread::class)->create();
        factory(Reply::class)->create(['replyable_id' => $thread->id()]);

        $this->dispatch(new DeleteThread($thread));

        $this->assertDatabaseMissing('threads', ['id' => $thread->id()]);
        $this->assertDatabaseMissing('replies', ['replyable_id' => $thread->id()]);
    }
}
