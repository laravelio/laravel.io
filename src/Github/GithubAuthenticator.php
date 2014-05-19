<?php namespace Lio\Github;

use Lio\Accounts\MemberRepository;
use Lio\Github\Requests\AccessTokenRequest;
use Lio\Github\Requests\UserEmailRequest;
use Lio\Github\Requests\UserRequest;

class GithubAuthenticator
{
    private $tokenRequest;
    private $memberRepository;
    private $emailRequest;
    private $userRequest;
    private $config;

    public function __construct($config, MemberRepository $memberRepository, AccessTokenRequest $tokenRequest, UserRequest $userRequest, UserEmailRequest $emailRequest)
    {
        $this->tokenRequest = $tokenRequest;
        $this->memberRepository = $memberRepository;
        $this->emailRequest = $emailRequest;
        $this->userRequest = $userRequest;
        $this->config = $config;
    }

    public function getAuthUrl($state = null)
    {
        $params = [
            'client_id' => $this->config['client_id'],
            'redirect_uri' => $this->config['redirect_url'],
            'scope' => implode(',', $this->config['scope']),
        ];
        if ($state) {
            $params['state'] = $state;
        }
        return 'https://github.com/login/oauth/authorize?' . http_build_query($params);
    }

    public function authorize($response, $state = null)
    {
        if ( ! $this->validateState($response, $state)) {
            return false;
        }

        $response = $this->tokenRequest->request($this->config['client_id'], $this->config['client_secret'], $response['code']);

        return $this->constructGithubUser(
            $this->userRequest->request($response['access_token']),
            $this->emailRequest->request($response['access_token'])
        );

        return $user;
    }

    private function validateState($response, $state)
    {
        if (is_null($state)) {
            return true;
        }
        if ( ! isset($response['state']) || $response['state'] != $state) {
            return false;
        }
        return true;
    }

    private function constructGithubUser(array $userData, array $emailData)
    {
        $primaryEmail = $this->getPrimaryEmail($emailData);
        return new GithubUser($userData['login'], $primaryEmail, $userData['html_url'], $userData['id'], $userData['avatar_url']);
    }

    private function getPrimaryEmail($emails)
    {
        foreach ($emails as $email) {
            if ($email->primary) {
                return $email->email;
            }
        }
        return null;
    }
}
