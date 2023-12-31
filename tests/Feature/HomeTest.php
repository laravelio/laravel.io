<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('users can see the homepage', function () {
    $this->get('/')
        ->assertSee('Laravel.io')
        ->assertSee('The Laravel Community Portal');
});

test('users can see a login and registration link when logged out', function () {
    $this->get('/')
        ->assertSeeText('Login', '<a>')
        ->assertSeeText('Register', '<a>')
        ->assertDontSee('Sign out');
});

test('users can see a logout button when logged in', function () {
    $this->login();

    $this->get('/')
        ->assertSee('Sign out')
        ->assertDontSeeText('Login', '<a>')
        ->assertDontSeeText('Register', '<a>')
        ->assertSee('Profile', '/user');
});
