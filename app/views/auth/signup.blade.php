@extends('layouts._one_column')

@section('content')
<section class="auth woops">
    <h1>Woops!</h1>
    <p>You'll need an account in order to do whatever you just tried to do. No problem, just authenticate through GitHub and you're done.</p>
    <a class="button full" href="{{ action('AuthController@getLogin') }}">Login with GitHub</a>
</section>
@stop