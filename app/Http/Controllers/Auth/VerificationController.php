<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails {
        resend as traitResend;
        verify as traitVerify;
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        /** @var \Illuminate\Http\RedirectResponse $response */
        $response = $this->traitVerify($request);

        if ($response->getSession()->has('verified')) {
            $this->success('Your email address was successfully verified.');
        } else {
            $this->error('We could not verify your email address. The given email address and code did not match.');
        }

        return $response;
    }

    public function resend(Request $request)
    {
        /** @var \Illuminate\Http\RedirectResponse $response */
        $response = $this->traitResend($request);

        if ($response->getSession()->has('resent')) {
            $this->success('Email verification sent to :0. You can change your email address in your profile settings.', $request->user()->emailAddress());
        } else {
            $this->error('Your email address is already verified.');
        }

        return $response;
    }
}
