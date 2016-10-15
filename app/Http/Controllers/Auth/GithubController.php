<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Social\GithubRepository;
use App\Social\GithubUser;
use App\Users\User;
use App\Users\UserRepository;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Socialite;

class GithubController extends Controller
{
    /**
     * @var \App\Users\UserRepository
     */
    private $users;

    /**
     * @var \App\Social\GithubRepository
     */
    private $github;

    public function __construct(UserRepository $users, GithubRepository $github)
    {
        $this->users = $users;
        $this->github = $github;
    }

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
        $socialiteUser = Socialite::driver('github')->user();

        try {
            $user = $this->users->findByGithubId($socialiteUser->getId());

            return $this->userFound($user);
        } catch (ModelNotFoundException $exception) {
            $user = $this->github->findByUsername($socialiteUser->getNickname());

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
        if ($user->isYoungerThanTwoWeeks()) {
            return $this->redirectUserToHome();
        }

        return $this->redirectUserToRegistration($user);
    }

    private function redirectUserToHome(): RedirectResponse
    {
        $this->error('Your Github account needs to be older than 2 weeks in order to register.');

        return redirect()->home();
    }

    private function redirectUserToRegistration(GithubUser $user): RedirectResponse
    {
        session(['githubData' => $user->toArray()]);

        return redirect()->route('register');
    }
}
