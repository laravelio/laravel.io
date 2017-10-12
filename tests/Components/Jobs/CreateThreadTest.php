<?php

namespace Tests\Components\Jobs;

use App\Jobs\CreateThread;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

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
