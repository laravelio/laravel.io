<?php

use Illuminate\Session\SessionManager;
use Lio\Github\GithubAuthenticator;
use Lio\Github\GithubAuthenticatorListener;
use Lio\Accounts\UserCreatorResponder;
use Lio\Accounts\Commands;

class AuthController extends BaseController implements GithubAuthenticatorListener, UserCreatorResponder
{
    /**
     * @var CommandBus
     */
    private $bus;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var AuthManager
     */
    private $auth;
    /**
     * @var Redirector
     */
    private $redirector;
    /**
     * @var Lio\Github\GithubAuthenticator
     */
    private $githubAuthenticator;
    /**
     * @var Illuminate\Session\SessionManager
     */
    private $session;

    function __construct(CommandBus $bus, Request $request, AuthManager $auth, Redirector $redirector, GithubAuthenticator $githubAuthenticator, SessionManager $session)
    {
        $this->bus = $bus;
        $this->request = $request;
        $this->auth = $auth;
        $this->redirector = $redirector;
        $this->githubAuthenticator = $githubAuthenticator;
        $this->session = $session;
    }

    public function getLogin()
    {
        $code = $this->request->has('code');
        if ($code) {
            return $this->githubAuthenticator->authByCode($this, $code);
        }
        $this->redirector->to((string) OAuth::consumer('GitHub')->getAuthorizationUri());
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
        return $this->redirector->action('HomeController@getIndex');
    }

    public function userNotFound($githubData)
    {
        $this->session->put('userGithubData', $githubData);
        return $this->redirector->action('AuthController@getSignupConfirm');
    }

    public function getLogout()
    {
        $this->auth->logout();
        return $this->redirector->action('HomeController@getIndex');
    }

    // page that a user sees if they try to do something that requires an authed session
    public function getLoginRequired()
    {
        $this->view('auth.loginrequired');
    }

    // the confirmation page that shows a user what their new account will look like
    public function getSignupConfirm()
    {
        if ( ! $this->session->has('userGithubData')) {
            return $this->redirector->action('AuthController@getLogin');
        }
        $this->view('auth.signupconfirm', [
            'githubUser' => $this->session->has('userGithubData'),
        ]);
    }

    // actually creates the new user account
    public function postSignupConfirm()
    {
        if ( ! $this->session->has('userGithubData')) {
            return $this->redirector->action('AuthController@getLogin');
        }

        $github = $this->session->get('userGithubData');

        $command = new Commands\CreateUserCommand(
            $github['email'],
            $github['login'],
            $github['html_url'],
            $github['id'],
            $github['avatar_url']
        );

        $user = $this->bus->execute($command);

        $this->auth->login($user, true);
        $this->session->forget('userGithubData');

        return $this->redirectIntended(action('HomeController@getIndex'));
    }
}
