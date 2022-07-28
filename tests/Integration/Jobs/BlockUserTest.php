<?php

use App\Jobs\BlockUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('can block a user', function () {
    $blocker = $this->createUser();
    $blocked = $this->createUser([
        'username' => 'blocked',
        'email' => 'blocked@example.com',
    ]);

    $this->loginAs($blocker);

    $this->dispatch(new BlockUser($blocker, $blocked));

    expect($blocker->hasBlocked($blocked))->toBeTrue();
});
