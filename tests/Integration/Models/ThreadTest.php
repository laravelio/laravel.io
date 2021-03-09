<?php

namespace Tests\Integration\Models;

use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_find_by_slug()
    {
        Thread::factory()->create(['slug' => 'foo']);

        $this->assertInstanceOf(Thread::class, Thread::findBySlug('foo'));
    }

    /** @test */
    public function it_can_give_an_excerpt_of_its_body()
    {
        $thread = Thread::factory()->make(['body' => 'This is a pretty long text.']);

        $this->assertEquals('This is...', $thread->excerpt(7));
    }

    /** @test */
    public function its_conversation_is_old_when_the_oldest_reply_was_six_months_ago()
    {
        $thread = Thread::factory()->create();
        $thread->repliesRelation()->save(Reply::factory()->make(['created_at' => now()->subMonths(7)]));

        $this->assertTrue($thread->isConversationOld());

        $thread = Thread::factory()->create();
        $thread->repliesRelation()->save(Reply::factory()->make());

        $this->assertFalse($thread->isConversationOld());
    }

    /** @test */
    public function its_conversation_is_old_when_there_are_no_replies_but_the_creation_date_was_six_months_ago()
    {
        $thread = Thread::factory()->create(['created_at' => now()->subMonths(7)]);

        $this->assertTrue($thread->isConversationOld());

        $thread = Thread::factory()->create();

        $this->assertFalse($thread->isConversationOld());
    }

    /** @test */
    public function we_can_mark_and_unmark_a_reply_as_the_solution()
    {
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);

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

    /** @test */
    public function it_can_retrieve_only_resolved_threads()
    {
        $this->createThreadFromToday();
        $resolvedThread = $this->createResolvedThread();

        $threads = Thread::feedQuery()->resolved()->get();

        $this->assertCount(1, $threads);
        $this->assertTrue($resolvedThread->matches($threads->first()));
    }

    /** @test */
    public function it_can_retrieve_only_active_threads()
    {
        $this->createThreadFromToday();
        $activeThread = $this->createActiveThread();

        $threads = Thread::feedQuery()->active()->get();

        $this->assertCount(1, $threads);
        $this->assertTrue($activeThread->matches($threads->first()));
    }

    /** @test */
    public function it_generates_a_slug_when_valid_url_characters_provided()
    {
        $thread = Thread::factory()->make(['slug' => 'Help with eloquent']);

        $this->assertEquals('help-with-eloquent', $thread->slug());
    }

    /** @test */
    public function it_generates_a_unique_slug_when_valid_url_characters_provided()
    {
        $threadOne = Thread::factory()->create(['slug' => 'Help with eloquent']);
        $threadTwo = Thread::factory()->create(['slug' => 'Help with eloquent']);

        $this->assertEquals('help-with-eloquent-1', $threadTwo->slug());
    }

    /** @test */
    public function it_generates_a_slug_when_invalid_url_characters_provided()
    {
        $thread = Thread::factory()->make(['slug' => '한글 테스트']);

        // When providing a slug with invalid url characters, a random 5 character string is returned.
        $this->assertMatchesRegularExpression('/\w{5}/', $thread->slug());
    }

    private function createThreadFromToday(): Thread
    {
        $today = Carbon::now();

        return Thread::factory()->create(['created_at' => $today]);
    }

    private function createThreadFromYesterday(): Thread
    {
        $yesterday = Carbon::yesterday();

        return Thread::factory()->create(['created_at' => $yesterday]);
    }

    private function createThreadFromTwoDaysAgo(): Thread
    {
        $twoDaysAgo = Carbon::now()->subDay(2);

        return Thread::factory()->create(['created_at' => $twoDaysAgo]);
    }

    private function createResolvedThread()
    {
        $thread = $this->createThreadFromToday();
        $reply = Reply::factory()->create();
        $thread->markSolution($reply);

        return $thread;
    }

    private function createActiveThread()
    {
        $thread = $this->createThreadFromToday();
        $reply = Reply::factory()->create();
        $reply->to($thread);
        $reply->save();

        return $thread;
    }
}
