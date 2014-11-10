@extends('layouts._one_column')

@section('content')
    <section class="auth">
        <h1>We're going to create an account with this information.</h1>

        <div class="user">
            {{ Form::open(['id' => 'signup-form']) }}
                <img src="{{ $githubUser['image_url'] }}"/>

                <div class="bio">
                    @if (isset($githubUser['name']))
                        <h2>{{ $githubUser['name'] }}</h2>
                    @endif

                    @if (isset($githubUser['email']))
                        <p>{{ $githubUser['email'] }}</p>
                    @endif

                    <p>{{ Form::label('captcha', 'Please fill out the captcha:') }}</p>
                    <p>{{ HTML::image(Captcha::img(), 'Captcha image', ['class' => 'captcha']) }}</p>
                    <p>{{ Form::text('captcha') }}</p>

                    @if ($errors->has('captcha'))
                        <p>{{ $errors->first('captcha') }}</p>
                    @endif

                    {{ Form::submit('Create My Laravel.IO Account', ['class' => 'button']) }}
                </div>
            {{ Form::close() }}
        </div>

    </section>
@stop