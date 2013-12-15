<?php namespace Lio\GitHub;

use GitHub, OAuth, Session;

/**
* This class can call the following methods on the observer object:
*
* userFound($user)
* userIsBanned($user)
* signupConfirmationRequired($githubData)
*/
class GithubAccountIntegrator
{
    protected $users;

    public function __construct(GithubAccountIntegratorObserver $observer, $users)
    {
        $this->observer = $observer;
        $this->users = $users;
    }

    public function integrateByAuthCode($code)
    {
        // --- this needs to be extracted to a new method --- //
        $github = OAuth::consumer('GitHub');
        $oauthTokenObject = $github->requestAccessToken($code);
        $githubData = json_decode($github->request('user'), true);
        $emails = json_decode($github->request('user/emails'), true);
        $githubData['email'] = last($emails);
        // --- end of code that needs to be extracted --- //

        $user = $this->users->getByGithubId($githubData['id']);

        if ($user) {
            return $this->loginUser($user, $githubData);
        }

        return $this->observer->signupConfirmationRequired($githubData);
    }

    // this class should obviously be refactored into multiple classes
    public function createAccountFromGithubData($githubData)
    {
        $user = $this->users->getNew();
        $this->users->updateFromGithubData($user, $githubData);
        $this->users->save($user);

        return $this->observer->userFound($user);
    }

    private function loginUser($user, $githubData)
    {
        if ( ! $user->is_banned) {
            $this->users->updateFromGithubData($user, $githubData);
            $this->users->save($user);
            return $this->observer->userFound($user);
        }

        return $this->observer->userIsBanned($user);
    }
}
