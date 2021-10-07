<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('anyone can see a user profile', function () {
    $this->createUser();

    $this->visit('/user/johndoe')
        ->see('John Doe');
});

test('admin buttons are not shown to logged out users', function () {
    $this->createUser();

    $this->visit('/user/johndoe')
        ->dontSee('Ban user')
        ->dontSee('Unban user')
        ->dontSee('Delete user');
});

test('admin buttons are not shown to non admin users', function () {
    $this->login();

    $this->visit('/user/johndoe')
        ->dontSee('Ban user')
        ->dontSee('Unban user')
        ->dontSee('Delete user');
});

test('admin buttons are shown to admin users', function () {
    $this->createUser([
        'username' => 'janedoe',
        'email' => 'jane@example.com',
    ]);
    $this->loginAsAdmin();

    $this->visit('/user/janedoe')
        ->see('Ban user')
        ->see('Delete user');
});

test('delete button is not shown to moderators', function () {
    $this->createUser([
        'username' => 'janedoe',
        'email' => 'jane@example.com',
    ]);
    $this->loginAsModerator();

    $this->visit('/user/janedoe')
        ->see('Ban user')
        ->dontSee('Delete user');
});
