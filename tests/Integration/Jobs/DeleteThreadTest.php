<?php

namespace Tests\Integration\Jobs;

use App\Jobs\DeleteThread;
use App\Models\Like;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_delete_a_thread_and_its_replies()
    {
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);
        Like::factory()->thread()->create(['likeable_id' => $thread->id()]);
        Like::factory()->reply()->create(['likeable_id' => $reply->id()]);

        $this->dispatch(new DeleteThread($thread));

        $this->assertDatabaseMissing('threads', ['id' => $thread->id()]);
        $this->assertDatabaseMissing('replies', ['replyable_id' => $thread->id()]);
        $this->assertDatabaseMissing('likes', ['likeable_type' => 'threads', 'likeable_id' => $thread->id()]);
        $this->assertDatabaseMissing('likes', ['likeable_type' => 'replies', 'likeable_id' => $reply->id()]);
    }
}
