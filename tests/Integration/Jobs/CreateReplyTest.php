<?php

use App\Events\ReplyWasCreated;
use App\Jobs\CreateReply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can create a reply', function () {
    $user = $this->createUser();
    $thread = Thread::factory()->create();

    $this->expectsEvents(ReplyWasCreated::class);

    $reply = $this->dispatch(new CreateReply('Foo', $user, $thread));

    expect($reply->body())->toEqual('Foo');
});
