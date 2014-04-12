@extends('layouts._one_column')

@section('content')
    <section class="auth">
        <h1>We&#39;re going to create an account with this information. You can change these details in the future by updating your Github account information and then logging into this site.</h1>

        <div class="user">
            {{ Form::open() }}
            <img src="{{ $githubUser->imageUrl }}"/>
            <div class="bio">
                @if(isset($githubUser->name))
                    <h2>{{ $githubUser->name }}</h2>
                @endif
                @if(isset($githubUser->email))
                    <h3>{{ $githubUser->email }}</h3>
                @endif
                {{ Form::submit('Create My Laravel.IO Account', ['class' => 'button']) }}
            </div>
            {{ Form::close() }}
        </div>

    </section>
@stop
