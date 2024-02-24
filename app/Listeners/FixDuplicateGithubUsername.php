<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use App\Social\GithubUserApi;
use Illuminate\Auth\Events\Registered;

final class FixDuplicateGithubUsername
{
    public function __construct(
        private readonly GithubUserApi $github
    ){
    }

    public function handle(Registered $event): void
    {
        $users = User::query()
            ->whereGithubUsername($event->user->github_username)
            ->where('id', '!=', $event->user->id)
            ->latest()
            ->get();

        $users->each(function (User $user) {
            $githubUser = $this->github->find($user->github_id);

            if (! $githubUser) {
                $user->update(['github_username' => null]);
                return;
            }

            // since github_id is unique, we can safely update the github_username
            $user->update(['github_username' => $githubUser->login]);
        });
    }
}
