<?php

use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('can find by slug', function () {
    Thread::factory()->create(['slug' => 'foo']);

    $this->assertInstanceOf(Thread::class, Thread::findBySlug('foo'));
});

it('can give an excerpt of its body', function () {
    $thread = Thread::factory()->make(['body' => 'This is a pretty long text.']);

    $this->assertEquals('This is...', $thread->excerpt(7));
});

test('html in excerpts is html encoded', function () {
    $thread = Thread::factory()->make(['body' => '<p>Thread body</p>']);

    $this->assertEquals("&lt;p&gt;Thread body&lt;/p&gt;\n", $thread->excerpt());
});

test('its conversation is old when the oldest reply was six months ago', function () {
    $thread = Thread::factory()->create();
    $thread->repliesRelation()->save(Reply::factory()->make(['created_at' => now()->subMonths(7)]));

    $this->assertTrue($thread->isConversationOld());

    $thread = Thread::factory()->create();
    $thread->repliesRelation()->save(Reply::factory()->make());

    $this->assertFalse($thread->isConversationOld());
});

test('its conversation is old when there are no replies but the creation date was six months ago', function () {
    $thread = Thread::factory()->create(['created_at' => now()->subMonths(7)]);

    $this->assertTrue($thread->isConversationOld());

    $thread = Thread::factory()->create();

    $this->assertFalse($thread->isConversationOld());
});

test('we can mark and unmark a reply as the solution', function () {
    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['replyable_id' => $thread->id()]);

    $this->assertFalse($thread->isSolutionReply($reply));

    $thread->markSolution($reply);

    $this->assertTrue($thread->isSolutionReply($reply));

    $thread->unmarkSolution();

    $this->assertFalse($thread->isSolutionReply($reply));
});

it('can retrieve the latest threads in a correct order', function () {
    $threadUpdatedYesterday = createThreadFromYesterday();
    $threadFromToday = createThreadFromToday();
    $threadFromTwoDaysAgo = createThreadFromTwoDaysAgo();

    $threads = Thread::feed();

    $this->assertTrue($threadFromToday->is($threads->first()), 'First thread is incorrect');
    $this->assertTrue($threadUpdatedYesterday->is($threads->slice(1)->first()), 'Second thread is incorrect');
    $this->assertTrue($threadFromTwoDaysAgo->is($threads->last()), 'Last thread is incorrect');
});

it('can retrieve only resolved threads', function () {
    createThreadFromToday();
    $resolvedThread = createResolvedThread();

    $threads = Thread::feedQuery()->resolved()->get();

    $this->assertCount(1, $threads);
    $this->assertTrue($resolvedThread->is($threads->first()));
});

it('can retrieve only active threads', function () {
    createThreadFromToday();
    $activeThread = createActiveThread();

    $threads = Thread::feedQuery()->active()->get();

    $this->assertCount(1, $threads);
    $this->assertTrue($activeThread->is($threads->first()));
});

it('generates a slug when valid url characters provided', function () {
    $thread = Thread::factory()->make(['slug' => 'Help with eloquent']);

    $this->assertEquals('help-with-eloquent', $thread->slug());
});

it('generates a unique slug when valid url characters provided', function () {
    $threadOne = Thread::factory()->create(['slug' => 'Help with eloquent']);
    $threadTwo = Thread::factory()->create(['slug' => 'Help with eloquent']);

    $this->assertEquals('help-with-eloquent-1', $threadTwo->slug());
});

it('generates a slug when invalid url characters provided', function () {
    $thread = Thread::factory()->make(['slug' => '한글 테스트']);

    // When providing a slug with invalid url characters, a random 5 character string is returned.
    $this->assertMatchesRegularExpression('/\w{5}/', $thread->slug());
});

// Helpers
function createThreadFromToday(): Thread
{
    $today = Carbon::now();

    return Thread::factory()->create(['created_at' => $today]);
}

function createThreadFromYesterday(): Thread
{
    $yesterday = Carbon::yesterday();

    return Thread::factory()->create(['created_at' => $yesterday]);
}

function createThreadFromTwoDaysAgo(): Thread
{
    $twoDaysAgo = Carbon::now()->subDay(2);

    return Thread::factory()->create(['created_at' => $twoDaysAgo]);
}

function createResolvedThread()
{
    $thread = createThreadFromToday();
    $reply = Reply::factory()->create();
    $thread->markSolution($reply);

    return $thread;
}

function createActiveThread()
{
    $thread = createThreadFromToday();
    $reply = Reply::factory()->create();
    $reply->to($thread);
    $reply->save();

    return $thread;
}
