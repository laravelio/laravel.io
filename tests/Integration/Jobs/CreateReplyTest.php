<?php

namespace Tests\Integration\Jobs;

use App\Events\ReplyWasCreated;
use App\Jobs\CreateReply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_reply()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create();

        $this->expectsEvents(ReplyWasCreated::class);

        $reply = $this->dispatch(new CreateReply('Foo', $user, $thread));

        $this->assertEquals('Foo', $reply->body());
    }
}
