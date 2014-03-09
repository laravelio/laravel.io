<?php

App::error(function(\Lio\CommandBus\CommandValidationFailedException $exception) {
    $messages = (array) json_decode($exception->getMessage());
    $errors = new \Illuminate\Support\MessageBag($messages);
    return Redirect::back()->withInput()->withErrors($errors);
});

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
        if ( ! stristr($request->path(), 'login') && ! stristr($request->path(), 'signup')) Session::put('auth.intended_redirect_url', $request->url());
    }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
*/

Route::filter('auth', function() {
    if (Auth::guest()) return Redirect::action('AuthController@getLoginRequired');
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
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::filter('has_role', function($route, $request, $parameters) {
    $allowedRoles = explode(',', $parameters);

    if (Auth::check() and Auth::user()->hasRoles($allowedRoles)) {
        return;
    }

    throw new Lio\Core\Exceptions\NotAuthorizedException(Auth::user()->name . ' does not have the required role(s): ' . $parameters);
});

//Event::listen('illuminate.query', function($sql, $bindings)
//{
//    if (App::environment('local')) {
//        foreach ($bindings as $i => $val) {
//            $bindings[$i] = "'$val'";
//        }
//
//        $sql = str_replace(['?'], $bindings, $sql);
//        Log::info($sql);
//    }
//});
