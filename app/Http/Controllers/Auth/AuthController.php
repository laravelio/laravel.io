<?php
namespace Lio\Http\Controllers\Auth;

use Auth;
use Input;
use Lio\Accounts\SendConfirmationEmail;
use Lio\Accounts\User;
use Lio\Accounts\UserCreator;
use Lio\Accounts\UserCreatorListener;
use Lio\Accounts\UserRepository;
use Lio\Github\GithubAuthenticator;
use Lio\Github\GithubAuthenticatorListener;
use Lio\Http\Controllers\Controller;
use Request;
use Session;
use Socialite;
use Validator;

class AuthController extends Controller implements GithubAuthenticatorListener, UserCreatorListener
{
    /**
     * @var \Lio\Github\GithubAuthenticator
     */
    private $github;

    /**
     * @var \Lio\Accounts\UserRepository
     */
    private $users;

    /**
     * @var \Lio\Accounts\UserCreator
     */
    private $userCreator;

    /**
     * @var \Lio\Accounts\SendConfirmationEmail
     */
    private $confirmation;

    /**
     * @param \Lio\Github\GithubAuthenticator $github
     * @param \Lio\Accounts\UserRepository $users
     * @param \Lio\Accounts\UserCreator $userCreator
     * @param \Lio\Accounts\SendConfirmationEmail $confirmation
     */
    public function __construct(
        GithubAuthenticator $github,
        UserRepository $users,
        UserCreator $userCreator,
        SendConfirmationEmail $confirmation
    ) {
        $this->github = $github;
        $this->users = $users;
        $this->userCreator = $userCreator;
        $this->confirmation = $confirmation;

        $this->middleware('guest', ['except' => ['logout', 'confirmEmail', 'resendEmailConfirmation']]);
        $this->middleware('auth', ['only' => ['logout', 'resendEmailConfirmation']]);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authByGithub()
    {
        return $this->github->authBySocialite($this);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function signup()
    {
        if (! Session::has('githubData')) {
            return redirect()->route('login');
        }

        return view('auth.signup', ['githubData' => Session::get('githubData')]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register()
    {
        if (! Session::has('githubData')) {
            return redirect()->route('login');
        }

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make(Input::only('g-recaptcha-response'), [
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return redirect()->route('signup')
                ->exceptInput('g-recaptcha-response')
                ->withErrors($validator->errors());
        }

        $data = Session::get('githubData');
        $data['ip'] = Request::ip();
        $data['name'] = Input::get('name');
        $data['email'] = Input::get('email');

        return $this->userCreator->create($this, $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->home();
    }

    /**
     * Confirms a user's email address
     *
     * @param string $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmEmail($code)
    {
        if (! $user = $this->users->getByConfirmationCode($code)) {
            abort(404);
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        Auth::login($user, true);

        session(['success' => 'Your email was successfully confirmed.']);

        return redirect()->home();
    }

    /**
     * Re-sends the confirmation email
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendEmailConfirmation()
    {
        $this->confirmation->send(Auth::user());

        session(['success' => 'A new email confirmation was sent to ' . Auth::user()->email]);

        return redirect()->home();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invalidLogin()
    {
        Session::put('error', 'Invalid login');

        return redirect()->home();
    }

    /**
     * @param \Lio\Accounts\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userFound(User $user)
    {
        Auth::login($user, true);

        return $this->redirectIntended(route('home'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userIsBanned()
    {
        Session::put('error', 'Your account has been banned. If you\'d like to appeal, please contact us through the support widget below.');

        return redirect()->home();
    }

    /**
     * @param array $githubData
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userNotFound($githubData)
    {
        Session::put('githubData', $githubData);

        return redirect()->route('signup');
    }

    /**
     * @param $errors
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userValidationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    /**
     * @param \Lio\Accounts\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userCreated($user)
    {
        Session::forget('githubData');
        Session::put('success', 'Account created. An email confirmation was sent to ' . $user->email);

        Auth::login($user, true);

        return $this->redirectIntended(route('home'));
    }
}
