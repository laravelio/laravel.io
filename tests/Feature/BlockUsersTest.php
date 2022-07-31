<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(RefreshDatabase::class);

test('cannot block user when not logged in', function () {
    $user = $this->createUser();

    $this->put("/users/{$user->username}/block")->assertRedirectedTo('login');
});

test('cannot unblock user when not logged in', function () {
    $user = $this->createUser();

    $this->put("/users/{$user->username}/unblock")->assertRedirectedTo('login');
});

test('cannot block self', function () {
    $user = $this->createUser();

    $this->loginAs($user);

    $this->put("/users/{$user->username}/block")->assertForbidden();
});

test('cannot block moderator', function () {
    $user = $this->createUser();
    $moderator = $this->createUser([
        'username' => 'moderator',
        'email' => 'moderator@example.com',
        'type' => User::MODERATOR,
    ]);

    $this->loginAs($user);

    $this->put("/users/{$moderator->username}/block")->assertForbidden();
});

test('can block other user', function () {
    $blocker = $this->createUser();
    $blocked = $this->createUser([
        'username' => 'blocked',
        'email' => 'blocked@example.com',
    ]);

    $this->loginAs($blocker);

    $this->put("/users/{$blocked->username}/block")->assertSessionHas('success', trans('settings.user.blocked'));
});

test('can unblock other user', function () {
    $unblocker = $this->createUser();
    $unblocked = $this->createUser([
        'username' => 'unblocked',
        'email' => 'unblocked@example.com',
    ]);

    $this->loginAs($unblocker);

    $this->put("/users/{$unblocked->username}/unblock")->assertSessionHas('success', trans('settings.user.unblocked'));
});
