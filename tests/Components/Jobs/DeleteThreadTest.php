<?php

namespace Tests\Components\Jobs;

use App\Jobs\DeleteThread;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_delete_a_thread_and_its_replies()
    {
        $thread = factory(Thread::class)->create();
        factory(Reply::class)->create(['replyable_id' => $thread->id()]);

        (new DeleteThread($thread))->handle();

        $this->assertDatabaseMissing('threads', ['id' => $thread->id()]);
        $this->assertDatabaseMissing('replies', ['replyable_id' => $thread->id()]);
    }
}
