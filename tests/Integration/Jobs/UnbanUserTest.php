<?php

use App\Jobs\UnbanUser;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(LazilyRefreshDatabase::class);

it('can unban a user', function () {
    $user = $this->createUser(['banned_at' => Carbon::yesterday()]);

    $this->dispatch(new UnbanUser($user));

    $unbannedUser = $user->fresh();

    expect($unbannedUser->isBanned())->toBeFalse();
    expect($unbannedUser->bannedReason())->toBeNull();
});
