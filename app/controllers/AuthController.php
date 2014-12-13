<?php

use Lio\Accounts\SendConfirmationEmail;
use Lio\Accounts\UserRepository;
use Lio\Github\GithubAuthenticatorListener;
use Lio\Accounts\UserCreatorListener;

class AuthController extends BaseController implements GithubAuthenticatorListener, UserCreatorListener
{
    /**
     * @var \Lio\Accounts\UserRepository
     */
    protected $users;

    /**
     * @var \Lio\Accounts\SendConfirmationEmail
     */
    protected $confirmation;

    /**
     * @param \Lio\Accounts\UserRepository $users
     * @param \Lio\Accounts\SendConfirmationEmail $confirmation
     */
    public function __construct(UserRepository $users, SendConfirmationEmail $confirmation)
    {
        $this->users = $users;
        $this->confirmation = $confirmation;
    }

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
        $validator = Validator::make(Input::only('g-recaptcha-response'), [
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        if ($validator->fails()) {
            return Redirect::action('AuthController@getSignupConfirm')
                ->exceptInput('g-recaptcha-response')
                ->withErrors($validator->errors());
        }

        $data = Session::get('userGithubData');
        $data['ip'] = Request::ip();

        return App::make('Lio\Accounts\UserCreator')->create($this, $data);
    }

    /**
     * Confirms a user's email address
     *
     * @param string $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getConfirmEmail($code)
    {
        if (! $code) {
            App::abort(404);
        }

        $user = $this->users->getByConfirmationCode($code);

        if (! $user) {
            App::abort(404);
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        Auth::login($user, true);

        return Redirect::home()->with('success', 'Your email was successfully confirmed.');
    }

    /**
     * Re-sends the confirmation email
     *
     * @param string $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getResendConfirmation($code)
    {
        $user = $this->users->getByConfirmationCode($code);

        if (! $user) {
            App::abort(404);
        }

        $this->confirmation->send($user);

        return Redirect::home()->with('success', 'A new email confirmation was sent to ' . $user->email);
    }

    // user creator responses
    public function userValidationError($errors)
    {
        return Redirect::to('/');
    }

    public function userCreated($user)
    {
        Session::forget('userGithubData');

        Session::flash('success', 'Account created. An email confirmation was sent to ' . $user->email);

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
        Session::flash('error', 'Your account has been banned. If you\'d like to appeal, please contact us through the support widget below.');

        return $this->redirectHome();
    }

    public function userIsntConfirmed($user)
    {
        Session::flash('error', 'Please confirm your email address (' . $user->email . ') before trying to login.
        <a style="color:#fff" href="' . route('user.reconfirm', $user->confirmation_code) . '">Re-send confirmation email.</a>');

        return $this->redirectHome();
    }

    public function userNotFound($githubData)
    {
        Session::put('userGithubData', $githubData);

        return $this->redirectAction('AuthController@getSignupConfirm');
    }
}
