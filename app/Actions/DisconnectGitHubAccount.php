<?php

namespace App\Actions;

use App\Models\User;

final class DisconnectGitHubAccount
{
    public function __invoke(User $user): void
    {
        $user->update([
            'github_id' => null,
            'github_username' => null,
            'github_has_identicon' => false,
        ]);
    }
}
