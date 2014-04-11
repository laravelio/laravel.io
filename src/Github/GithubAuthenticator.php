<?php namespace Lio\Github;

use Lio\Accounts\UserRepository;

class GithubAuthenticator
{
    protected $users;

    public function __construct(UserRepository $users, GithubUserDataReader $reader)
    {
        $this->users = $users;
        $this->reader = $reader;
    }

    public function authByCode($code)
    {
        die('login is disabled atm');
        $user = $this->users->getByGithubId($githubData['id']);

        if ($user) {
            return $this->loginUser($listener, $user, $githubData);
        }

        return $listener->userNotFound($githubData);
    }

    private function loginUser($listener, $user, $githubData)
    {
        if ($user->is_banned) {
            return $listener->userIsBanned($user);
        }

        $user->fill($githubData);
        $this->users->save($user);
        return $listener->userFound($user);
    }
}
