<?php 

use Lio\Accounts\UserRepository;

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
            return $this->processCode(Input::get('code'));
        }

        return $this->redirectTo((string) GitHub::getAuthorizationUri());
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

    private function processCode($code)
    {
        $githubUser = GitHub::getUserDataByCode(Input::get('code'));

        $user = $this->users->getByGithubId($githubUser['id']);

        if ($user) {
            if ( ! $user->is_banned) {
                $this->users->updateFromGithubData($user, $githubUser);
                $this->users->save($user);

                Auth::login($user);
                return $this->redirectIntended(action('HomeController@getIndex'));
            }

            return $this->redirectAction('HomeController@getIndex');
        }

        if (Session::has('signupGithubData')) {
            return $this->createUser($githubUser);
        }

        Session::put('signupGithubData', $githubUser);
        return $this->redirectAction('AuthController@getSignupConfirm');
    }

    private function createUser($githubUser)
    {
        $user = $this->users->getNew();
        $this->users->updateFromGithubData($user, $githubUser);
        $this->users->save($user);

        Session::forget('signupGithubData');

        Auth::login($user);

        return $this->redirectIntended(action('HomeController@getIndex'));
    }
}
