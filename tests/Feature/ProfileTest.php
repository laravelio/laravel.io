<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('anyone can see a user profile', function () {
    $this->createUser();

    $this->get('/user/johndoe')
        ->assertSee('John Doe');
});

test('admin buttons are not shown to logged out users', function () {
    $this->createUser();

    $this->get('/user/johndoe')
        ->assertDontSee('Ban user')
        ->assertDontSee('Unban user');
});

test('admin buttons are not shown to non admin users', function () {
    $this->login();

    $this->get('/user/johndoe')
        ->assertDontSee('Ban user')
        ->assertDontSee('Unban user');
});

test('admin buttons are shown to admin users', function () {
    $this->createUser([
        'username' => 'janedoe',
        'email' => 'jane@example.com',
    ]);
    $this->loginAsAdmin();

    $this->get('/user/janedoe')
        ->assertSee('Ban User');
});
