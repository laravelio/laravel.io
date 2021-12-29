<?php

use App\Jobs\DeleteApiToken;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('deletes the specified API token for the given user', function () {
    $user = $this->createUser();

    $user->createToken('foo');
    $barToken = $user->createToken('bar');
    $user->createToken('baz');

    $this->dispatch(new DeleteApiToken($user, $barToken->accessToken->getKey()));

    expect($user->refresh()->tokens)->toHaveCount(2);
    expect($barToken->accessToken->fresh())->toBeNull();
});

it('will not delete anything if the given API token does not belong to the user', function () {
    $user = $this->createUser();
    $token = $user->createToken('foo');

    $this->dispatch(new DeleteApiToken(UserFactory::new()->create(), $token->accessToken->getKey()));

    expect($user->refresh()->tokens)->toHaveCount(1);
    expect($token->accessToken->fresh())->not->toBeNull();
});
