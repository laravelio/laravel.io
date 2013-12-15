<?php

use Lio\GitHub\GithubAccountIntegrator;
use Lio\GitHub\GithubAccountIntegratorObserver;

class AuthController extends BaseController implements GithubAccountIntegratorObserver
{
    public function getLogin()
    {
        if (Input::has('code')) {
            $integrator = new GithubAccountIntegrator($this, App::make('Lio\Accounts\UserRepository'));
            return $integrator->integrateByAuthCode(Input::get('code'));
        }

        // redirect to the github authentication url
        Session::forget('signupGithubData');
        return $this->redirectTo((string) OAuth::consumer('GitHub')->getAuthorizationUri());
    }

    public function getLogout()
    {
        Auth::logout();
        return $this->redirectAction('HomeController@getIndex');
    }

    public function getSignup()
    {
        $this->view('auth.signup');
    }

    public function getSignupConfirm()
    {
        if ( ! Session::has('signupGithubData')) {
            return $this->redirectAction('AuthController@getLogin');
        }

        $this->view('auth.signupconfirm', ['githubUser' => Session::get('signupGithubData')]);
    }

    public function getSignupConfirmed()
    {
        if ( ! Session::has('signupGithubData')) {
            return $this->redirectAction('AuthController@getLogin');
        }

        $integrator = new GithubAccountIntegrator($this, App::make('Lio\Accounts\UserRepository'));
        return $integrator->createAccountFromGithubData(Session::get('signupGithubData'));
    }

    // github account integration observers
    public function userFound($user)
    {
        Auth::login($user);
        Session::forget('signupGithubData');
        return $this->redirectIntended(action('HomeController@getIndex'));
    }

    public function userIsBanned($user)
    {
        return $this->redirectAction('HomeController@getIndex');
    }

    public function signupConfirmationRequired($githubData)
    {
        Session::put('signupGithubData', $githubData);
        return $this->redirectAction('AuthController@getSignupConfirm');
    }
}
