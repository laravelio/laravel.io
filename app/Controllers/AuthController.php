<?php namespace Controllers;

use Lio\Accounts\User;
use GitHub;
use Auth, Input, Log, Redirect;

class AuthController extends BaseController
{
    public function getLogin()
    {
        if (Input::has('code')) {
            $user = User::getByOauthCode(Input::get('code'));

            Auth::login($user);

            return Redirect::to('');
        }

        // redirect to GitHub for oauth approval
        return Redirect::to((string) GitHub::getAuthorizationUri());
    }

    public function getLogout()
    {
        Auth::logout();

        return Redirect::to('');
    }
}