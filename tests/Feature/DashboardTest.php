<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Arr;

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
        $thread = Arr::first(factory(Thread::class, 3)->create(['author_id' => $user->id()]));
        $reply = Arr::first(factory(Reply::class, 2)->create([
            'author_id' => $user->id(),
            'replyable_id' => $thread->id(),
        ]));
        $thread->markSolution($reply);

        $this->loginAs($user);

        $this->visit('/dashboard')
            ->see('3 threads')
            ->see('2 replies')
            ->see('1 solution');
    }
}
