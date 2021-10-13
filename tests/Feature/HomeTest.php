<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('users can see the homepage', function () {
    $this->visit('/')
        ->see('Laravel.io')
        ->see('The Laravel Community Portal');
});

test('users can see a login and registration link when logged out', function () {
    $this->visit('/')
        ->seeLink('Login')
        ->seeLink('Register')
        ->dontSeeLink('Sign out');
});

test('users can see a logout button when logged in', function () {
    $this->login();

    $this->visit('/')
        ->seeLink('Sign out')
        ->dontSeeLink('Login')
        ->dontSeeLink('Register')
        ->seeLink('Profile', '/user');
});
