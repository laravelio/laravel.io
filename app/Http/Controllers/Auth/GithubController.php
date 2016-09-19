<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Users\UserRepository;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Socialite;

class GithubController extends Controller
{
    /**
     * @var \App\Users\UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
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
        } catch (ModelNotFoundException $exception) {
            session()->put('githubData', [
                'id' => $socialiteUser->getId(),
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'username' => $socialiteUser->getNickname(),
            ]);

            return redirect()->route('register');
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
