<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Models\Thread;
use App\Jobs\CreateReply;
use App\Events\ReplyWasCreated;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_reply()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create();

        $this->expectsEvents(ReplyWasCreated::class);

        $reply = $this->dispatch(new CreateReply('Foo', '', $user, $thread));

        $this->assertEquals('Foo', $reply->body());
    }
}
