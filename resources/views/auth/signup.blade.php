@extends('layouts._one_column')

@section('content')
    <section class="auth">
        <h1>We're going to create an account with this information.</h1>

        <div class="user">
            {!! Form::open() !!}
                <div class="bio">
                    <p><img src="{{ $githubData['image_url'] }}"/></p>

                    <p>
                        {!! Form::label('name', 'Username') !!}
                        {!! Form::text('name', Input::old('name', $githubData['name'])) !!}
                    </p>

                    @if ($errors->has('name'))
                        <p>{!! $errors->first('name') !!}</p>
                    @endif

                    <p>
                        {!! Form::label('email') !!}
                        {!! Form::email('email', Input::old('email', $githubData['email'])) !!}
                    </p>

                    @if ($errors->has('email'))
                        <p>{!! $errors->first('email') !!}</p>
                    @endif

                    <p>{!! app('captcha')->display(); !!}</p>

                    @if ($errors->has('g-recaptcha-response'))
                      g  <p>Please fill in the captcha field correctly.</p>
                    @endif

                    {!! Form::submit('Create My Laravel.io Account', ['class' => 'button']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop
