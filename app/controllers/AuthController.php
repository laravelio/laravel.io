<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Lio\Accounts\MemberNotFoundException;
use Lio\Accounts\UseCases\LoginMemberThroughGithubRequest;
use Lio\Accounts\UseCases\RegisterMemberRequest;
use Lio\CommandBus\CommandBus;
use Lio\Github\GithubAuthenticator;

class AuthController extends BaseController
{
    protected $bus;
    protected $request;
    protected $redirector;

    private $github;

    public function __construct(CommandBus $bus, Request $request, Redirector $redirector, SessionManager $session, Environment $view, AuthManager $auth, GithubAuthenticator $github)
    {
        $this->bus = $bus;
        $this->request = $request;
        $this->redirector = $redirector;
        $this->session = $session;
        $this->view = $view;
        $this->auth = $auth;
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
        $this->auth->logout();
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

        $request = new RegisterMemberRequest(
            $githubUser->name,
            $githubUser->email,
            $githubUser->githubUrl,
            $githubUser->githubId,
            $githubUser->imageUrl
        );

        $member = $this->bus->execute($request);

        $this->auth->login($member, true);
        $this->session->forget('githubUser');

        return $this->redirectIntended(action('ForumThreadsController@getIndex'));
    }
}
