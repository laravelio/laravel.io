<?php namespace Lio\GitHub;

interface GithubAccountIntegratorObserver
{
    public function userFound($user);
    public function userIsBanned($user);
    public function signupConfirmationRequired($githubData);
}