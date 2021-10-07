<?php

use App\Exceptions\CannotCreateUser;
use App\Jobs\RegisterUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('we can create a user', function () {
    $user = $this->dispatch(
        new RegisterUser('John Doe', 'john@example.com', 'johndoe', 'password', '123', 'johndoe'),
    );

    expect($user->name())->toEqual('John Doe');
});

test('we cannot create a user with the same email address', function () {
    $this->expectException(CannotCreateUser::class);

    $this->dispatch(new RegisterUser('John Doe', 'john@example.com', 'johndoe', '', 'password', '123', 'johndoe'));
    $this->dispatch(new RegisterUser('John Doe', 'john@example.com', 'john', '', 'password', '123', 'johndoe'));
});

test('we cannot create a user with the same username', function () {
    $this->expectException(CannotCreateUser::class);

    $this->dispatch(new RegisterUser('John Doe', 'john@example.com', 'johndoe', '', 'password', '123', 'johndoe'));
    $this->dispatch(new RegisterUser('John Doe', 'doe@example.com', 'johndoe', '', 'password', '123', 'johndoe'));
});
