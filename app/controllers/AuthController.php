<?php

use Lio\Accounts\MemberNotFoundException;
use Lio\Accounts\UseCases\LoginMemberThroughGithubRequest;
use Lio\Github\GithubAuthenticator;

class AuthController extends BaseController
{
    protected $bus;
    protected $request;
    protected $redirector;

    private $github;

    public function __construct(CommandBus $bus, Request $request, Redirector $redirector, GithubAuthenticator $github)
    {
        $this->bus = $bus;
        $this->request = $request;
        $this->redirector = $redirector;
        $this->github = $github;
    }

    public function getLogin()
    {
        if ( ! $this->request->has('code')) {
            return $this->redirector->to($this->github->getAuthUrl());
        }

        $githubUser = $this->github->authorize($this->request->all());

        $request = new LoginMemberThroughGithubRequest($githubUser);

        try {
            $member = $this->bus->execute($request);
        } catch (MemberNotFoundException $e) {
            $this->session->put('githubUser', $githubUser);
            return $this->redirector->action('AuthController@getSignupConfirm');
        }

        $this->auth->login($member);
        $this->session->forget('userGithubData');
        return $this->redirectIntended(action('ForumThreadsController@getIndex'));
    }

    public function getLogout()
    {
        $request = new \Lio\Accounts\UseCases\LogoutMemberRequest();
        $this->bus->execute($request);
        return $this->redirector->action('ForumThreadsController@getIndex');
    }

    // page that a user sees if they try to do something that requires an authed session
    public function getLoginRequired()
    {
        $this->render('auth.loginrequired');
    }

    // the confirmation page that shows a user what their new account will look like
    public function getSignupConfirm()
    {
        if ( ! $this->session->has('githubUser')) {
            return $this->redirector->action('AuthController@getLogin');
        }

        $this->render('auth.signupconfirm', [
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

        $command = new Commands\CreateUserFromGithubCommand($githubUser);

        $user = $this->bus->execute($command);

        $this->auth->login($user, true);
        $this->session->forget('githubUser');

        return $this->redirectIntended(action('ForumThreadsController@getIndex'));
    }
}
