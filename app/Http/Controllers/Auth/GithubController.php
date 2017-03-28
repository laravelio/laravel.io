<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Social\GithubUsers;
use App\Social\GithubUser;
use App\Users\User;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Socialite;

class GithubController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     */
    public function handleProviderCallback(GithubUsers $githubUsers)
    {
        $socialiteUser = Socialite::driver('github')->user();

        try {
            $user = User::findByGithubId($socialiteUser->getId());

            return $this->userFound($user);
        } catch (ModelNotFoundException $exception) {
            $user = $githubUsers->findByUsername($socialiteUser->getNickname());

            return $this->userNotFound($user);
        }
    }

    private function userFound(User $user): RedirectResponse
    {
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function userNotFound(GithubUser $user): RedirectResponse
    {
        if ($user->isTooYoung()) {
            $this->error('errors.github_account_too_young');

            return redirect()->home();
        }

        return $this->redirectUserToRegistrationPage($user);
    }

    private function redirectUserToRegistrationPage(GithubUser $user): RedirectResponse
    {
        session(['githubData' => $user->toArray()]);

        return redirect()->route('register');
    }
}
