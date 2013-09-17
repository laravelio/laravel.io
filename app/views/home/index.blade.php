Hello!

@if(Auth::check())
    You are logged in as {{ Auth::user()->name }}.
@else
    <a href="{{ action('Controllers\AuthController@getLogin') }}">Login with GitHub</a>
@endif