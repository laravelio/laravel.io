@extends('layouts._one_column')

@section('content')
<section class="auth">
    <h1>We&#39;re going to create an account with this information.</h1>

    <div class="user">
        <img src="{{ $githubUser['avatar_url'] }}"/>
        <div class="bio">
            <h2>{{ $githubUser['name'] }}</h2>
            <h3>{{ $githubUser['email'] }}</h3>
            <a class="button" href="{{ action('AuthController@getLogin') }}">Create My Laravel.IO Account</a>
        </div>
    </div>


</section>
@stop
