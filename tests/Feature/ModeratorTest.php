<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class ModeratorTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function moderators_can_edit_any_thread()
    {
        $thread = factory(Thread::class)->create();

        $this->loginAsModerator();

        $this->visit('/forum/'.$thread->slug().'/edit')
            ->assertResponseOk();
    }

    /** @test */
    public function moderators_can_delete_any_thread()
    {
        $thread = factory(Thread::class)->create();

        $this->loginAsModerator();

        $this->delete('/forum/'.$thread->slug())
            ->assertRedirectedTo('/forum');
    }
}
