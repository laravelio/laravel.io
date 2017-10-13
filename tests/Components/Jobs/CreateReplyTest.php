<?php

namespace Tests\Components\Jobs;

use App\Models\Thread;
use App\Jobs\CreateReply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateReplyTest extends JobTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_reply()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create();

        $reply = $this->dispatch(new CreateReply('Foo', '', $user, $thread));

        $this->assertEquals('Foo', $reply->body());
    }
}
