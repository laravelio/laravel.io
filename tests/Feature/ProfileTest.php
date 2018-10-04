<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Support\Facades\Bus;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function anyone_can_see_a_user_profile()
    {
        $this->createUser();

        $this->visit('/user/johndoe')
            ->see('John Doe');
    }

    /** @test */
    public function anyone_can_delete_their_profile()
    {
        $user = $this->login();

        $thread1 = factory(Thread::class)->create(['author_id' => $user->getKey()]);
        $thread2= factory(Thread::class)->create(['author_id' => $user->getKey()]);

        factory(Reply::class)->create(['author_id' => $user->getKey(), 'replyable_id' => $thread1->getKey()]);
        factory(Reply::class)->create(['author_id' => $user->getKey(), 'replyable_id' => $thread1->getKey()]);
        factory(Reply::class)->create(['author_id' => $user->getKey(), 'replyable_id' => $thread2->getKey()]);

        $this->assertEquals(2, $user->countThreads());
        $this->assertEquals(3, $user->countReplies());

        $this->delete(route('profile.destroy'))
            ->assertRedirectedToRoute('login');

        $this->assertEquals(0, $user->countThreads());
        $this->assertEquals(0, $user->countReplies());

        $this->assertFalse($user->exists());
    }
}
