<?php

namespace Tests\Components\Jobs;

use App\Jobs\CreateThread;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends JobTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_thread()
    {
        $user = $this->createUser();

        $thread = $this->dispatch(new CreateThread('Subject', 'Body', '', $user));

        $this->assertEquals('Subject', $thread->subject());
    }
}
