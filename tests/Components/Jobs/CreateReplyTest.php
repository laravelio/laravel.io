<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use App\Jobs\CreateReply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_reply()
    {
        $job = new CreateReply('Foo', '', $this->createUser(), factory(Thread::class)->create());

        $this->assertInstanceOf(Reply::class, $job->handle());
    }
}
