<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Users\SendEmailAddressConfirmation;
use App\Users\User;
use App\Users\UserRepository;
use Auth;

class EmailAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'sendConfirmation']);
    }

    public function sendConfirmation()
    {
        if (Auth::user()->isConfirmed()) {
            $this->error('auth.confirmation.already_confirmed');
        } else {
            $this->dispatch(new SendEmailAddressConfirmation(Auth::user()));

            $this->success('auth.confirmation.sent', ['emailAddress' => Auth::user()->emailAddress()]);
        }

        return redirect()->route('dashboard');
    }

    public function confirm(UserRepository $users, User $user, string $code)
    {
        if (! $user->matchesConfirmationCode($code)) {
            $this->success('auth.confirmation.no_match');
        } else {
            $users->confirmUser($user);

            $this->success('auth.confirmation.success');
        }

        return Auth::check() ? redirect()->route('dashboard') : redirect()->home();
    }
}
