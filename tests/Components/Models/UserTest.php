<?php

namespace Tests\Components\Models;

use App\Models\Subscription;
use App\User;
use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_find_by_username()
    {
        $this->createUser(['username' => 'johndoe']);

        $this->assertInstanceOf(User::class, User::findByUsername('johndoe'));
    }

    /** @test */
    public function it_can_find_by_email_address()
    {
        $this->createUser(['email' => 'john@example.com']);

        $this->assertInstanceOf(User::class, User::findByEmailAddress('john@example.com'));
    }

    /** @test */
    public function it_can_return_the_amount_of_solutions_that_were_given()
    {
        $user = factory(User::class)->create();
        $this->createTwoSolutionReplies($user);

        $this->assertEquals(2, $user->countSolutions());
    }

    private function createTwoSolutionReplies(User $user)
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['replyable_id' => $thread->id(), 'author_id' => $user->id()]);
        $thread->markSolution($reply);

        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['replyable_id' => $thread->id(), 'author_id' => $user->id()]);
        $thread->markSolution($reply);
    }

    /** @test */
    public function it_can_check_if_its_subscribed_to_a_thread()
    {
        $user = $this->createUser();
        $thread = factory(Thread::class)->create();
        factory(Subscription::class)->create(['user_id' => $user->id(), 'subscriptionable_id' => $thread->id()]);

        $this->assertTrue($user->isSubscribedTo($thread));
    }
}
