<?php

use App\Jobs\BanUser;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(LazilyRefreshDatabase::class);

it('can ban a user', function () {
    $user = $this->createUser(['banned_at' => null]);

    $reason = 'A good reason';

    $this->dispatch(new BanUser($user, $reason));

    $bannedUser = $user->fresh();

    expect($bannedUser->isBanned())->toBeTrue();
    expect($bannedUser->bannedReason())->toBe('A good reason');
});
