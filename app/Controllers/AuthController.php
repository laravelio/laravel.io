<?php namespace Controllers;

use Lio\Accounts\UserRepository;
use GitHub;
use Auth, Input, Log;

class AuthController extends BaseController
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getLogin()
    {
        if (Input::has('code')) {
            $user = $this->users->getByOauthCode(Input::get('code'));

            Auth::login($user);

            return $this->redirectAction('Controllers\HomeController@getIndex');
        }

        // redirect to GitHub for oauth approval
        return $this->redirectTo((string) GitHub::getAuthorizationUri());
    }

    public function getLogout()
    {
        Auth::logout();

        return $this->redirectAction('Controllers\HomeController@getIndex');
    }
}