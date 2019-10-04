<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ConfirmUser;
use App\Jobs\SendEmailConfirmation;
use App\User;
use Auth;
use Illuminate\Auth\Middleware\Authenticate;

class EmailConfirmationController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class, ['only' => 'send']);
    }

    public function send()
    {
        if (Auth::user()->isConfirmed()) {
            $this->error('auth.confirmation.already_confirmed');
        } else {
            $this->dispatch(new SendEmailConfirmation(Auth::user()));

            $this->success('auth.confirmation.sent', Auth::user()->emailAddress());
        }

        return redirect()->route('dashboard');
    }

    public function confirm(User $user, string $code)
    {
        if ($user->matchesConfirmationCode($code)) {
            $this->dispatchNow(new ConfirmUser($user));

            $this->success('auth.confirmation.success');
        } else {
            $this->error('auth.confirmation.no_match');
        }

        return Auth::check() ? redirect()->route('dashboard') : redirect()->home();
    }
}
