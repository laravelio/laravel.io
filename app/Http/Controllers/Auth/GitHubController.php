<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateProfile;
use App\Models\User;
use App\Social\GitHubUser;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteUser;
use function Pest\Laravel\instance;

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
            $this->error('The request timed out. Please try again.');

            return redirect()->route('login');
        }

        if ($socialiteUser instanceof RedirectResponse) {
            return $socialiteUser;
        }

        try {
            $user = User::findByGitHubId($socialiteUser->getId());
        } catch (ModelNotFoundException $exception) {
            return $this->userNotFound(new GitHubUser($socialiteUser->getRaw()));
        }

        return $this->userFound($user, $socialiteUser);
    }

    private function getSocialiteUser(): SocialiteUser|RedirectResponse
    {
        try {
            return Socialite::driver('github')->user();
        } catch (ClientException|ServerException $e) {
            $this->error('An error occurred while trying to log in with GitHub. Please try again.');

            return redirect()->route('login');
        }
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
            $this->error('Your GitHub account needs to be older than 2 weeks in order to register.');

            return redirect()->route('home');
        }

        if (! $user->hasPublicRepositories()) {
            $this->error('Your GitHub account needs to have at least 1 public repository in order to register.');

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
