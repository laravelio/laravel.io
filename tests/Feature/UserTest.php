<?php

use App\Models\User;
use Tests\TestCase;

uses(TestCase::class);

it('can determine if it has a password set', function () {
    $user = new User(['password' => 'foo']);

    expect($user->hasPassword())->toBeTrue();
});
