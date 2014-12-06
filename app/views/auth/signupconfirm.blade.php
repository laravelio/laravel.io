@extends('layouts._one_column')

@section('content')
    <section class="auth">
        <h1>We're going to create an account with this information.</h1>

        <div class="user">
            {{ ReCaptcha::getScript() }}
            {{ Form::open(['id' => 'signup-form']) }}
                <img src="{{ $githubUser['image_url'] }}"/>

                <div class="bio">
                    @if (isset($githubUser['name']))
                        <h2>{{ $githubUser['name'] }}</h2>
                    @endif

                    @if (isset($githubUser['email']))
                        <p>{{ $githubUser['email'] }}</p>
                    @endif

                    <p>{{ ReCaptcha::getWidget() }}</p>

                    @if ($errors->has('g-recaptcha-response'))
                        <p>Please fill in the captcha field correctly.</p>
                    @endif

                    {{ Form::submit('Create My Laravel.IO Account', ['class' => 'button']) }}
                </div>
            {{ Form::close() }}
        </div>

    </section>
@stop