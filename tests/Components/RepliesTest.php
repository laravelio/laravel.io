<?php

namespace Tests\Components;

use App\Jobs\CreateReply;
use App\Models\Thread;
use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RepliesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function we_can_create_a_reply()
    {
        $job = new CreateReply('Foo', '', $this->createUser(), factory(Thread::class)->create());

        $this->assertInstanceOf(Reply::class, $job->handle());
    }
}
