<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('anyone can see a user profile', function () {
    $this->createUser();

    $this->get('/user/johndoe')
        ->assertSee('John Doe');
});

test('a profile displays a custom hero image', function () {
    Storage::fake('public');
    Storage::disk('public')->put('profile-hero-images/johndoe.jpg', 'profile hero image');

    $this->createUser(['hero_image_path' => 'profile-hero-images/johndoe.jpg']);

    $this->get('/user/johndoe')
        ->assertSee(Storage::disk('public')->url('profile-hero-images/johndoe.jpg'), false);
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
