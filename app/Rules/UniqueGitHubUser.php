<?php

namespace App\Rules;

use App\Concerns\SendsAlerts;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UniqueGitHubUser implements ValidationRule
{
    use SendsAlerts;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $user = User::findByGitHubId($value);
        } catch (ModelNotFoundException) {
            return;
        }

        $message = $this->message($user);

        $this->error($message);

        $fail($message);
    }

    public function message(User $user): string
    {
        return __('We already found a user with the given GitHub account (:username). Would you like to <a href=":login">login</a> instead?', [
            'username' => '@'.$user->githubUsername(),
            'login' => route('login'),
        ]);
    }
}
