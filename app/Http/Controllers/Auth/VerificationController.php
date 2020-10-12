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
            $this->success('auth.verification.success');
        } else {
            $this->error('auth.verification.no_match');
        }

        return $response;
    }

    public function resend(Request $request)
    {
        /** @var \Illuminate\Http\RedirectResponse $response */
        $response = $this->traitResend($request);

        if ($response->getSession()->has('resent')) {
            $this->success('auth.verification.sent', $request->user()->emailAddress());
        } else {
            $this->error('auth.verification.already_verified');
        }

        return $response;
    }
}
