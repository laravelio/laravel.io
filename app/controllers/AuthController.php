<?php

use Lio\Accounts\Commands;
use Illuminate\Http\Request;
use Lio\CommandBus\CommandBus;
use Lio\Accounts\UserRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Redirector;
use Lio\Github\GithubAuthenticator;
use Lio\Accounts\UserCreatorResponder;
use Illuminate\Session\SessionManager;

class AuthController extends BaseController
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
    private $github;
    /**
     * @var Illuminate\Session\SessionManager
     */
    private $session;
    /**
     * @var Lio\Accounts\UserRepository
     */
    private $userRepository;

    function __construct(CommandBus $bus, Request $request, UserRepository $userRepository, AuthManager $auth, Redirector $redirector, GithubAuthenticator $github, SessionManager $session)
    {
        $this->bus = $bus;
        $this->auth = $auth;
        $this->github = $github;
        $this->request = $request;
        $this->session = $session;
        $this->redirector = $redirector;
        $this->userRepository = $userRepository;
    }

    public function getLogin()
    {
        if ( ! $this->request->has('code')) {
            return $this->redirector->to($this->github->getAuthUrl());
        }

        $githubUser = $this->github->authorize($this->request->all());
        $user = $this->userRepository->getGithubUser($githubUser);

        if ($user) {
            $this->auth->login($user, true);
            $this->session->forget('userGithubData');
            return $this->redirectIntended(action('ForumThreadsController@getIndex'));
        }

        $this->session->put('githubUser', $githubUser);
        return $this->redirector->action('AuthController@getSignupConfirm');
    }

    // implement banned user

    public function getLogout()
    {
        $this->auth->logout();
        return $this->redirector->action('ForumThreadsController@getIndex');
    }

    // page that a user sees if they try to do something that requires an authed session
    public function getLoginRequired()
    {
        $this->view('auth.loginrequired');
    }

    // the confirmation page that shows a user what their new account will look like
    public function getSignupConfirm()
    {
        if ( ! $this->session->has('githubUser')) {
            return $this->redirector->action('AuthController@getLogin');
        }

        $this->view('auth.signupconfirm', [
            'githubUser' => $this->session->get('githubUser'),
        ]);
    }

    // actually creates the new user account
    public function postSignupConfirm()
    {
        if ( ! $this->session->has('githubUser')) {
            return $this->redirector->action('AuthController@getLogin');
        }

        $githubUser = $this->session->get('githubUser');

        $command = new Commands\CreateUserCommand(
            $githubUser->email,
            $githubUser->name,
            $githubUser->githubUrl,
            $githubUser->githubId,
            $githubUser->imageUrl
        );

        $user = $this->bus->execute($command);

        $this->auth->login($user, true);
        $this->session->forget('githubUser');

        return $this->redirectIntended(action('ForumThreadsController@getIndex'));
    }
}
