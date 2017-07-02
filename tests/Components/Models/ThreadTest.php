<?php

namespace Tests\Components\Models;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_find_by_slug()
    {
        factory(Thread::class)->create(['slug' => 'foo']);

        $this->assertInstanceOf(Thread::class, Thread::findBySlug('foo'));
    }

    /** @test */
    public function it_can_give_an_excerpt_of_its_body()
    {
        $thread = factory(Thread::class)->make(['body' => 'This is a pretty long text.']);

        $this->assertEquals('This is...', $thread->excerpt(7));
    }

    /** @test */
    public function we_can_mark_and_unmark_a_reply_as_the_solution()
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['replyable_id' => $thread->id()]);

        $this->assertFalse($thread->isSolutionReply($reply));

        $thread->markSolution($reply);

        $this->assertTrue($thread->isSolutionReply($reply));

        $thread->unmarkSolution();

        $this->assertFalse($thread->isSolutionReply($reply));
    }

    /** @test */
    public function it_can_retrieve_the_latest_threads_in_a_correct_order()
    {
        $threadUpdatedYesterday = $this->createThreadFromYesterday();
        $threadFromToday = $this->createThreadFromToday();
        $threadFromTwoDaysAgo = $this->createThreadFromTwoDaysAgo();

        $threads = Thread::feed();

        $this->assertTrue($threadFromToday->matches($threads->first()), 'First thread is incorrect');
        $this->assertTrue($threadUpdatedYesterday->matches($threads->slice(1)->first()), 'Second thread is incorrect');
        $this->assertTrue($threadFromTwoDaysAgo->matches($threads->last()), 'Last thread is incorrect');
    }

    private function createThreadFromToday(): Thread
    {
        $today = Carbon::now();

        return factory(Thread::class)->create(['created_at' => $today]);
    }

    private function createThreadFromYesterday(): Thread
    {
        $yesterday = Carbon::yesterday();

        return factory(Thread::class)->create(['created_at' => $yesterday]);
    }

    private function createThreadFromTwoDaysAgo(): Thread
    {
        $twoDaysAgo = Carbon::now()->subDay(2);

        return factory(Thread::class)->create(['created_at' => $twoDaysAgo]);
    }
}
