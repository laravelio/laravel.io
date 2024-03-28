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
            $this->user = User::findByGitHubId($value);
        } catch (ModelNotFoundException) {
            return true;
        }

        return false;
    }

    public function message()
    {
        $this->error('We already found a user with the given GitHub account (:username). Would you like to <a href=":login">login</a> instead?', [
            'username' => '@'.$this->user->githubUsername(),
            'login' => route('login'),
        ]);
    }
}
