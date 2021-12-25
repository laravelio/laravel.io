<?php

namespace App\Rules;

use App\Concerns\SendsAlerts;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UniqueGitHubUser implements Rule
{
    use SendsAlerts;

    private User $user;

    public function passes($attribute, $value): bool
    {
        try {
            $this->user = User::findByGithubId($value);
        } catch (ModelNotFoundException) {
            return true;
        }

        return false;
    }

    public function message()
    {
        $this->error('errors.github_account_exists', [
            'username' => '@'.$this->user->githubUsername(),
            'login' => route('login'),
        ]);
    }
}
