<?php

namespace Tests\Components\Jobs;

use App\Jobs\CreateThread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_thread()
    {
        $user = $this->createUser();

        $thread = $this->dispatch(new CreateThread('Subject', 'Body', $user));

        $this->assertEquals('Subject', $thread->subject());
    }
}
