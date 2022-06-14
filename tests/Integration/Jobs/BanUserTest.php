<?php

use App\Jobs\BanUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('can ban a user', function () {
    $user = $this->createUser(['banned_at' => null, 'ban_message' => null]);

    $this->dispatch(new BanUser($user, ban_message: 'test'));

    $bannedUser = $user->fresh();

    expect($bannedUser->isBanned())->toBeTrue()
		->and($bannedUser->banMessage())->toEqual('test');
});
