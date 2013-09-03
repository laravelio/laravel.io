<?php namespace Lio\Admin;

class AuthController extends \Controllers\Base
{
    public function getIndex()
    {
        if (Auth::check()) {
            return $this->redirectAction('Controllers\Admin\Posts@getIndex');
        }

        return Redirect::action('Controllers\Admin\Auth@getLogin');
    }

    public function getLogin()
    {
        $this->render('admin.auth.login');
    }

    public function postLogin()
    {
        $credentials = [
            'email'    => Input::get('email'),
            'password' => Input::get('password')
        ];

        if ( ! Auth::attempt($credentials, Input::get('remember'))) {
            return $this->redirectBack(['loginform' => 'The email / password combination could not be found. Please try again.']);
        }

        return $this->redirectIntended(action('Controllers\Admin\Posts@getIndex'));
    }

    public function getLogout()
    {
        Auth::logout();

        return $this->redirectAction('Controllers\Admin\Auth@getLogin');
    }

    public function getForgotPassword()
    {
        $this->render('admin.auth.forgotpassword');
    }

    public function postForgotPassword()
    {
        return Password::remind(Input::only('email'), function($message) {
            $message->subject('Reset your Password');
        })->withInput();
    }

    public function getResetPassword($token)
    {
        $this->render('admin.auth.resetpassword', compact('token'));
    }

    public function postResetPassword($token)
    {
        return Password::reset(Input::only('email'), function($user, $password) use ($this as $self) {
            $user->password = $password;
            $user->save();

            Auth::login($user);

            return $self->redirectAction('Controllers\Admin\Posts@getIndex');
        })->withInput();
    }
}
