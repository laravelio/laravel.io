<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateProfile;
use App\Models\User;
use App\Social\GitHubUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteUser;

class GitHubController extends Controller
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
    public function handleProviderCallback()
    {
        try {
            $socialiteUser = $this->getSocialiteUser();
        } catch (InvalidStateException $exception) {
            $this->error('errors.github_invalid_state');

            return redirect()->route('login');
        }

        try {
            $user = User::findByGitHubId($socialiteUser->getId());
        } catch (ModelNotFoundException $exception) {
            return $this->userNotFound(new GitHubUser($socialiteUser->getRaw()));
        }

        return $this->userFound($user, $socialiteUser);
    }

    private function getSocialiteUser(): SocialiteUser
    {
        return Socialite::driver('github')->user();
    }

    private function userFound(User $user, SocialiteUser $socialiteUser): RedirectResponse
    {
        $this->dispatchSync(new UpdateProfile($user, ['github_username' => $socialiteUser->getNickname()]));

        Auth::login($user, true);

        return redirect()->route('profile');
    }

    private function userNotFound(GitHubUser $user): RedirectResponse
    {
        if ($user->isTooYoung()) {
            $this->error('errors.github_account_too_young');

            return redirect()->route('home');
        }

        if (! $user->hasPublicRepositories()) {
            $this->error('errors.github_account_no_repositories');

            return redirect()->route('home');
        }

        return $this->redirectUserToRegistrationPage($user);
    }

    private function redirectUserToRegistrationPage(GitHubUser $user): RedirectResponse
    {
        session(['githubData' => $user->toArray()]);

        return redirect()->route('register');
    }
}
