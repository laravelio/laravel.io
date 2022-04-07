<?php

use App\Jobs\CreateApiToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('creates an API token for the given user', function () {
    $user = $this->createUser();

    $this->dispatch(new CreateApiToken($user, 'Foo Bar'));

    expect($user->refresh()->tokens)
        ->toHaveCount(1)
        ->first()->name->toBe('Foo Bar');
});
