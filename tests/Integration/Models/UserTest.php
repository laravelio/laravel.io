<?php

namespace Tests\Integration\Models;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

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
        $user = User::factory()->create();
        $this->createTwoSolutionReplies($user);

        $this->assertEquals(2, $user->countSolutions());
    }

    /** @test */
    public function it_can_determine_if_a_given_user_is_the_logged_in_user()
    {
        $user = $this->login();

        $this->assertTrue($user->isLoggedInUser());
    }

    /** @test */
    public function it_can_determine_if_a_given_user_is_not_the_logged_in_user()
    {
        $user = $this->createUser();
        $this->login([
            'username' => 'janedoe',
            'email' => 'jane@example.com',
        ]);

        $this->assertFalse($user->isLoggedInUser());
    }

    private function createTwoSolutionReplies(User $user)
    {
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create(['replyable_id' => $thread->id(), 'author_id' => $user->id()]);
        $thread->markSolution($reply);

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create(['replyable_id' => $thread->id(), 'author_id' => $user->id()]);
        $thread->markSolution($reply);
    }
}
