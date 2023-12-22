<?php
namespace App\Jobs;

use App\Models\User;

final readonly class UpdateGithubUsername
{
    public function __construct(
        private User   $user,
        private ?string $githubUsername,
    ) {
    }

    public function handle(): void
    {
        $this->user->github_username = $this->githubUsername;
        $this->user->save();
    }
}
