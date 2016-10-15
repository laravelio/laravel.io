@title('Register')

@extends('layouts.small')

@section('small-content')
    {!! Form::open(['route' => 'register.post']) !!}
        @if (session()->has('githubData'))
            <div class="alert alert-info">
                Password isn't required when registering through Github.
            </div>
        @endif

        @formGroup('name')
            {!! Form::label('name') !!}
            {!! Form::text('name', session('githubData.name'), ['class' => 'form-control', 'required']) !!}
            @error('name')
        @endFormGroup

        @formGroup('email')
            {!! Form::label('email') !!}
            {!! Form::email('email', session('githubData.email'), ['class' => 'form-control', 'required']) !!}
            @error('email')
        @endFormGroup

        @formGroup('username')
            {!! Form::label('username') !!}
            {!! Form::text('username', session('githubData.username'), ['class' => 'form-control', 'required']) !!}
            @error('username')
        @endFormGroup

        @formGroup('password')
            {!! Form::label('password') !!}
            {!! Form::password('password', ['class' => 'form-control', Session::has('githubData') ? null : 'required']) !!}
            @error('password')
        @endFormGroup

        <div class="form-group">
            {!! Form::label('password_confirmation') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', Session::has('githubData') ? null : 'required']) !!}
        </div>

        @formGroup('g-recaptcha-response')
            {!! Recaptcha::render(['lang' => App::getLocale()]) !!}
            @error('g-recaptcha-response')
        @endFormGroup

        {!! Form::submit('Register', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
@stop
