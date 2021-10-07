<?php

use App\Jobs\CreateThread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can create a thread', function () {
    $user = $this->createUser();

    $thread = $this->dispatch(new CreateThread('Subject', 'Body', $user));

    expect($thread->subject())->toEqual('Subject');
});
