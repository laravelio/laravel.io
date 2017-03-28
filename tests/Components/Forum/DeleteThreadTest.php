<?php

namespace Tests\Components\Forum;

use App\Forum\Thread;
use App\Jobs\DeleteThread;
use App\Replies\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_can_delete_a_thread_and_its_replies()
    {
        $thread = factory(Thread::class)->create();
        factory(Reply::class)->create(['replyable_id' => $thread->id()]);

        (new DeleteThread($thread))->handle();

        $this->assertDatabaseMissing('threads', ['id' => $thread->id()]);
        $this->assertDatabaseMissing('replies', ['replyable_id' => $thread->id()]);
    }
}
