<?php

namespace Lio\Github;

use Lio\Accounts\User;

interface GithubAuthenticatorListener
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invalidLogin();

    /**
     * @param \Lio\Accounts\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userFound(User $user);

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userIsBanned();

    /**
     * @param array $githubData
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userNotFound($githubData);
}
