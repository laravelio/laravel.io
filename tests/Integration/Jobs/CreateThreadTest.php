<?php

use App\Jobs\CreateThread;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can create a thread', function () {
    $user = $this->createUser();

    $uuid = Str::uuid();

    $this->dispatch(new CreateThread($uuid, 'Subject', 'Body', $user));

    $thread = Thread::findByUuidOrFail($uuid);

    expect($thread->subject())->toEqual('Subject');
});
