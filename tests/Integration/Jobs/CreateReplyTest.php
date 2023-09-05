<?php

use App\Events\ReplyWasCreated;
use App\Jobs\CreateReply;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can create a reply', function () {
    Event::fake();

    $user = $this->createUser();
    $thread = Thread::factory()->create();

    $uuid = Str::uuid();

    $this->dispatch(new CreateReply($uuid, 'Foo', $user, $thread));

    $reply = Reply::findByUuidOrFail($uuid);

    expect($reply->body())->toEqual('Foo');

    Event::assertDispatched(ReplyWasCreated::class);
});
