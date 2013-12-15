<?php namespace Lio\Github;

use Lio\Accounts\UserRepository;

/**
* This class can call the following methods on the observer object:
*
* userFound($user)
* userIsBanned($user)
* signupConfirmationRequired($githubData)
*/
class GithubAuthenticator
{
    protected $users;

    public function __construct(UserRepository $users, GithubUserDataReader $reader)
    {
        $this->users = $users;
        $this->reader = $reader;
    }

    public function integrateByAuthCode($observer, $code)
    {
        $githubData = $this->reader->getDataFromCode($code);
        $user = $this->users->getByGithubId($githubData['id']);

        if ($user) {
            return $this->loginUser($observer, $user, $githubData);
        }

        return $observer->signupConfirmationRequired($githubData);
    }

    private function loginUser($observer, $user, $githubData)
    {
        if ( ! $user->is_banned) {
            $user->fill($githubData);
            $this->users->save($user);
            return $observer->userFound($user);
        }
        return $observer->userIsBanned($user);
    }
}
