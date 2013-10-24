We're going to create an account with this information.

<img src="{{ $githubUser['avatar_url'] }}"/>

<a href="{{ $githubUser['html_url'] }}">{{ $githubUser['name'] }} {{ $githubUser['email'] }}</a>

<a href="{{ action('AuthController@getLogin') }}">Create My Laravel.IO Account</a>