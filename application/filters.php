<?php

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
*/

Route::filter('before', function()
{
    $old_urls = array(
        'post/34826626980/hi-everyone-the-good-people-of-the-laravel-irc',
        'post/34824874902/reverse-routing-with-controller-actions',
        'post/35047820331/laravels-helper-functions',
        'post/35123649223/laravels-fluent-class-no-not-the-query-builder',
        'post/35194785834/registering-and-generating-paths',
        'post/35261335992/laravels-messages-class-its-not-just-for-validation',
        'post/35329484407/getting-information-about-a-route',
        'post/35554274120/naming-attributes-for-validation-messages',
        'post/35631566637/the-lifecycle-of-a-laravel-request-part-1',
        'post/35707247056/the-laravel-view-class',
        'post/35767651641/the-lifecycle-of-a-laravel-request-part-2',
        'post/35841995335/contributing-to-the-laravel-project',
    );

    $new_urls = array(
        'topic/1/hi-everyone-the-good-people-of-the-laravel-irc',
        'topic/2/reverse-routing-with-controller-actions',
        'topic/3/laravels-helper-functions',
        'topic/4/laravels-fluent-class-no-not-the-query-builder',
        'topic/5/registering-and-generating-paths',
        'topic/6/laravels-messages-class-its-not-just-for-validation',
        'topic/7/getting-information-about-a-route',
        'topic/8/naming-attributes-for-validation-messages',
        'topic/9/the-lifecycle-of-a-laravel-request-part-1',
        'topic/10/the-laravel-view-class',
        'topic/11/the-lifecycle-of-a-laravel-request-part-2',
        'topic/12/contributing-to-the-laravel-project',
    );

    $old_url_key = array_search(URI::current(), $old_urls);

    if($old_url_key !== false)
    {
        return Redirect::to($new_urls[$old_url_key], 301);
    }
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});