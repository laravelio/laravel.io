<?php

use App\Jobs\UpdateUserIdenticonStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('users can start connecting their GitHub account from settings', function () {
    $user = $this->login();

    $response = $this->actingAs($user)->post('/settings/github/connect');

    $response->assertRedirect(route('login.github'));

    expect(session('settings.github.connect.intended'))->toBeTrue();
});

test('users can disconnect their GitHub account from settings', function () {
    $user = $this->login([
        'github_id' => '11405387',
        'github_username' => 'theHocineSaad',
        'github_has_identicon' => true,
    ]);

    $response = $this->actingAs($user)->post('/settings/github/disconnect');

    $response->assertRedirect(route('settings.profile'));
    $response->assertSessionHas('success', 'Your GitHub account has been disconnected.');

    $user->refresh();

    expect($user->github_id)->toBeNull();
    expect($user->github_username)->toBeNull();
    expect($user->github_has_identicon)->toBeFalse();
});

test('users can connect their GitHub account after returning from GitHub', function () {
    Queue::fake();

    $user = $this->login([
        'github_id' => null,
        'github_username' => null,
    ]);

    $socialiteUser = fakeSocialiteUser('11405387', 'theHocineSaad');

    mockGitHubProvider($socialiteUser);

    $this->withSession(['settings.github.connect.intended' => true]);

    $response = $this->actingAs($user)->get('/auth/github');

    $response->assertRedirect(route('settings.profile'));
    $response->assertSessionHas('success', 'Your GitHub account has been connected.');

    $user->refresh();

    expect($user->github_id)->toBe('11405387');
    expect($user->github_username)->toBe('theHocineSaad');

    Queue::assertPushed(UpdateUserIdenticonStatus::class);
});

test('users cannot connect a GitHub account that belongs to another user', function () {
    Queue::fake();

    User::factory()->create([
        'github_id' => '11405387',
        'github_username' => 'theHocineSaad',
    ]);

    $user = $this->login([
        'github_id' => null,
        'github_username' => null,
    ]);

    $socialiteUser = fakeSocialiteUser('11405387', 'theHocineSaad');

    mockGitHubProvider($socialiteUser);

    $this->withSession(['settings.github.connect.intended' => true]);

    $response = $this->actingAs($user)->get('/auth/github');

    $response->assertRedirect(route('settings.profile'));
    $response->assertSessionHas('error', 'This GitHub account is already connected to another user.');

    $user->refresh();

    expect($user->github_id)->toBeNull();
    expect($user->github_username)->toBeNull();

    Queue::assertNothingPushed();
});

function fakeSocialiteUser(string $id, string $nickname): SocialiteUser
{
    return tap(new SocialiteUser())
        ->setRaw([
            'id' => $id,
            'login' => $nickname,
        ])
        ->map([
            'id' => $id,
            'nickname' => $nickname,
        ]);
}

function mockGitHubProvider(SocialiteUser $user): void
{
    $provider = Mockery::mock(Provider::class);
    $provider->shouldReceive('user')->once()->andReturn($user);

    Socialite::shouldReceive('driver')->once()->with('github')->andReturn($provider);
}
