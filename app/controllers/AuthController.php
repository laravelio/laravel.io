<?php

use Lio\Github\GithubAuthenticatorListener;
use Lio\Accounts\UserCreatorListener;

class AuthController extends BaseController implements GithubAuthenticatorListener, UserCreatorListener
{
    // authenticate with github
    public function getLogin()
    {
        if (Input::has('code')) {
            return App::make('Lio\Github\GithubAuthenticator')->authByCode($this, Input::get('code'));
        }

        // redirect to the github authentication url
        return $this->redirectTo((string) OAuth::consumer('GitHub')->getAuthorizationUri());
    }

    // logout
    public function getLogout()
    {
        Auth::logout();

        return $this->redirectAction('HomeController@getIndex');
    }

    // page that a user sees if they try to do something that requires an authed session
    public function getLoginRequired()
    {
        $this->view('auth.loginrequired');
    }

    // the confirmation page that shows a user what their new account will look like
    public function getSignupConfirm()
    {
        if (! Session::has('userGithubData')) {
            return $this->redirectAction('AuthController@getLogin');
        }

        $this->view('auth.signupconfirm', ['githubUser' => Session::get('userGithubData')]);
    }

    // actually creates the new user account
    public function postSignupConfirm()
    {
        if (! Session::has('userGithubData')) {
            return $this->redirectAction('AuthController@getLogin');
        }

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make(Input::only('captcha'), ['captcha' => 'required|captcha']);

        if ($validator->fails()) {
            return Redirect::action('AuthController@getSignupConfirm')->exceptInput('captcha')->withErrors($validator->errors());
        }

        return App::make('Lio\Accounts\UserCreator')->create($this, Session::get('userGithubData'));
    }

    // user creator responses
    public function userValidationError($errors)
    {
        return Redirect::to('/');
    }

    public function userCreated($user)
    {
        Auth::login($user, true);
        Session::forget('userGithubData');

        return $this->redirectIntended(action('HomeController@getIndex'));
    }

    // github account integration responses
    public function userFound($user)
    {
        Auth::login($user, true);
        Session::forget('userGithubData');

        return $this->redirectIntended(action('HomeController@getIndex'));
    }

    public function userIsBanned($user)
    {
        return $this->redirectAction('HomeController@getIndex');
    }

    public function userNotFound($githubData)
    {
        Session::put('userGithubData', $githubData);

        return $this->redirectAction('AuthController@getSignupConfirm');
    }
}
