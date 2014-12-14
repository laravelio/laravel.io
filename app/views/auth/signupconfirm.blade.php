@extends('layouts._one_column')

@section('content')
    <section class="auth">
        <h1>We're going to create an account with this information.</h1>

        <div class="user">
            {{ ReCaptcha::getScript() }}

            {{ Form::open() }}
                <div class="bio">
                    <p><img src="{{ $githubUser['image_url'] }}"/></p>

                    <p>
                        {{ Form::label('name') }}
                        {{ Form::text('name', Input::old('email', $githubUser['name'])) }}
                    </p>

                    @if ($errors->has('name'))
                        <p>{{ $errors->first('name') }}</p>
                    @endif

                    <p>
                        {{ Form::label('email') }}
                        {{ Form::email('email', Input::old('email', $githubUser['email'])) }}
                    </p>

                    @if ($errors->has('email'))
                        <p>{{ $errors->first('email') }}</p>
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