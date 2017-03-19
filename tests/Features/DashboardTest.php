<?php

namespace Tests\Features;

use App\Forum\Thread;
use App\Replies\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;
use Tests\RequiresLogin;

class DashboardTest extends BrowserKitTestCase
{
    use DatabaseMigrations, RequiresLogin;

    /**
     * @var string
     */
    protected $uri = '/dashboard';

    /** @test */
    function users_can_see_some_statistics()
    {
        $user = $this->login();

        $thread = array_first($this->create(Thread::class, ['author_id' => $user->id()], 3));
        $reply = array_first($this->create(Reply::class, ['author_id' => $user->id(), 'replyable_id' => $thread->id()], 2));
        Thread::where('id', $thread->id())->update(['solution_reply_id' => $reply->id()]);

        $this->visit('/dashboard')
            ->see('<div class="panel-body">3</div>') // 3 threads
            ->see('<div class="panel-body">2</div>') // 2 posts
            ->see('<div class="panel-body">1</div>'); // 1 solution
    }
}
