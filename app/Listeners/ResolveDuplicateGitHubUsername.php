<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use App\Social\GithubUserApi;
use Illuminate\Auth\Events\Registered;

final class ResolveDuplicateGitHubUsername
{
    public function __construct(private readonly GithubUserApi $github)
    {
    }

    public function handle(Registered $event): void
    {
        User::where('github_username', $event->user->github_username)
            ->whereKeyNot($event->user)
            ->latest()
            ->get()
            ->each(function (User $user) {
                $user->update([
                    'github_username' => $this->github->find($user->github_id)?->login(),
                ]);
            });
    }
}
