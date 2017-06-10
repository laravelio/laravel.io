<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DashboardTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function requires_login()
    {
        $this->visit('/dashboard')
            ->seePageIs('/login');
    }

    /** @test */
    public function users_can_see_some_statistics()
    {
        $user = $this->createUser();
        $thread = array_first(factory(Thread::class, 3)->create(['author_id' => $user->id()]));
        $reply = array_first(factory(Reply::class, 2)->create([
            'author_id' => $user->id(),
            'replyable_id' => $thread->id(),
        ]));
        $thread->markSolution($reply);

        $this->loginAs($user);

        $this->visit('/dashboard')
            ->see('<div class="panel-body">3</div>') // 3 threads
            ->see('<div class="panel-body">2</div>') // 2 posts
            ->see('<div class="panel-body">1</div>'); // 1 solution
    }
}
