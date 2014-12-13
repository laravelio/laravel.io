<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
*/

App::before(function($request) {
    // enforce no www
    if (preg_match('/^http:\/\/www./', $request->url())) {
        $newUrl = preg_replace('/^http:\/\/www./', 'http://', $request->url());
        return Redirect::to($newUrl);
    }
});

App::after(function($request, $response) {
    if (Auth::guest()) {
        if (
            ! stristr($request->path(), 'login') &&
            ! stristr($request->path(), 'signup') &&
            ! stristr($request->path(), 'g-recaptcha-response')
        ) {
            Session::put('auth.intended_redirect_url', $request->url());
        }
    }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
*/

Route::filter('auth', function() {
    if (Auth::guest()) {
        return Redirect::action('AuthController@getLoginRequired');
    } elseif (Auth::user()->is_banned) {
        // Don't allow people who are banned to log in.
        Session::flash('error', 'Your account has been banned. If you\'d like to appeal, please contact us through the support widget below.');

        Auth::logout();

        return Redirect::home();
    } elseif (! Auth::user()->isConfirmed()) {
        // Don't let people who haven't confirmed their email use the authed sections on the website.
        Session::flash('error', 'Please confirm your email address  (' . Auth::user()->email . ') before you try to login.
        <a style="color:#fff" href="' . route('user.reconfirm', Auth::user()->confirmation_code) . '">Re-send confirmation email.</a>');

        Auth::logout();

        return Redirect::home();
    }
});


Route::filter('auth.basic', function()
{
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
*/

Route::filter('guest', function() {
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
*/

Route::filter('csrf', function() {
    if (Session::token() !== Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::filter('has_role', function($route, $request, $parameters) {
    $allowedRoles = explode(',', $parameters);

    if (Auth::check() && Auth::user()->hasRoles($allowedRoles)) {
        return;
    }

    throw new Lio\Core\Exceptions\NotAuthorizedException(Auth::user()->name . ' does not have the required role(s): ' . $parameters);
});
