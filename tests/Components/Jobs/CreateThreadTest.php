<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Models\Thread;
use App\Jobs\CreateThread;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_thread()
    {
        $job = new CreateThread('Subject', 'Body', '', $this->createUser());

        $this->assertInstanceOf(Thread::class, $job->handle());
    }
}
