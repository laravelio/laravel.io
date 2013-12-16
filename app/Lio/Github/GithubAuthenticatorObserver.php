<?php namespace Lio\Github;

interface GithubAuthenticatorObserver
{
    public function userFound($user);
    public function userIsBanned($user);
    public function userNotFound($githubData);
}