<?php

namespace Tests\Features;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class ModeratorTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    function moderators_can_edit_any_thread()
    {
        $thread = factory(Thread::class)->create();

        $this->loginAsModerator();

        $this->visit('/forum/'.$thread->slug().'/edit')
            ->assertResponseOk();
    }

    /** @test */
    function moderators_can_delete_any_thread()
    {
        $thread = factory(Thread::class)->create();

        $this->loginAsModerator();

        $this->delete('/forum/'.$thread->slug())
            ->assertRedirectedTo('/forum');
    }
}
