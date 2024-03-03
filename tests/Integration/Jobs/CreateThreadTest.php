<?php

use App\Jobs\CreateThread;
use App\Models\Thread;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

uses(TestCase::class);
uses(LazilyRefreshDatabase::class);

test('we can create a thread', function () {
    $user = $this->createUser();

    $uuid = Str::uuid();

    $this->dispatch(new CreateThread($uuid, 'Subject', 'Body', $user));

    $thread = Thread::findByUuidOrFail($uuid);

    expect($thread->subject())->toEqual('Subject');
});
