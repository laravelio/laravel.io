<?php

use App\Jobs\BanUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('can ban a user', function () {
    $user = $this->createUser(['banned_at' => null, 'banned_reason' => null]);

    $this->dispatch(new BanUser($user, banned_reason: 'test'));

    $bannedUser = $user->fresh();

    expect($bannedUser->isBanned())->toBeTrue()
		->and($bannedUser->bannedReason())->toEqual('test');
});
