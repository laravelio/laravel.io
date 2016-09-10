<?php
namespace Lio\Github;

use Exception;
use Guzzle\Http\Client;
use Laravel\Socialite\Contracts\Provider as Socialite;
use Laravel\Socialite\Contracts\User as GithubUser;
use Lio\Accounts\User;
use Lio\Accounts\UserRepository;

class GithubAuthenticator
{
    /**
     * @var \Laravel\Socialite\Contracts\Provider
     */
    private $socialite;

    /**
     * @var \Lio\Accounts\UserRepository
     */
    protected $users;

    /**
     * @var \Guzzle\Http\Client
     */
    private $guzzle;

    /**
     * @param \Laravel\Socialite\Contracts\Provider $socialite
     * @param \Lio\Accounts\UserRepository $users
     */
    public function __construct(Socialite $socialite, UserRepository $users, Client $guzzle)
    {
        $this->socialite = $socialite;
        $this->users = $users;
        $this->guzzle = $guzzle;
    }

    /**
     * @param \Lio\Github\GithubAuthenticatorListener $listener
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authBySocialite(GithubAuthenticatorListener $listener)
    {
        try {
            $githubUser = $this->socialite->user();
        } catch (Exception $e) {
            return $listener->invalidLogin();
        }

        if ($user = $this->users->getByGithubId($githubUser->getId())) {
            return $this->loginUser($listener, $user);
        }

        return $listener->userNotFound($this->githubUserToArray($githubUser));
    }

    /**
     * @param \Lio\Github\GithubAuthenticatorListener $listener
     * @param \Lio\Accounts\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginUser(GithubAuthenticatorListener $listener, User $user)
    {
        if ($user->isBanned()) {
            return $listener->userIsBanned($user);
        }

        return $listener->userFound($user);
    }

    /**
     * @param \Laravel\Socialite\Contracts\User $user
     * @return array
     */
    private function githubUserToArray(GithubUser $user)
    {
        $data = json_decode($this->guzzle->get('https://api.github.com/users/'.$user->getNickname())->send()->getBody(true), true);

        return array_merge($data, [
            'id' => $user->getId(),
            'name' => $user->getNickname(),
            'email' => $user->getEmail(),
            'github_id'  => $user->getId(),
            'github_url' => 'https://github.com/' . $user->getNickname(),
            'image_url'  => $user->getAvatar(),
        ]);
    }
}
