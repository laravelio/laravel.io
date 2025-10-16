<?php

namespace App\Actions;

use App\Jobs\UpdateUserIdenticonStatus;
use App\Models\User;
use Laravel\Socialite\Two\User as SocialiteUser;

use function dispatch;

final class ConnectGitHubAccount
{
    public function __invoke(User $user, SocialiteUser $socialiteUser): void
    {
        $user->update([
            'github_id' => $socialiteUser->getId(),
            'github_username' => $socialiteUser->getNickname(),
        ]);

        dispatch(new UpdateUserIdenticonStatus($user));
    }
}
