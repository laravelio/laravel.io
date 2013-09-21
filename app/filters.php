<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
*/

App::before(function($request)
{
    //
});


App::after(function($request, $response)
{
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
*/

Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::action('Controllers\AuthController@getSignup');
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

Route::filter('guest', function()
{
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
*/

Route::filter('csrf', function()
{
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

// Event::listen('illuminate.query', function($sql, $bindings)
// {
//     foreach ($bindings as $i => $val) {
//         $bindings[$i] = "'$val'";
//     }

//     $sql = str_replace(['?'], $bindings, $sql);

//     Log::info($sql);
// }); 

