@title('Register')

@extends('layouts.small')

@section('small-content')
    {!! Form::open(['route' => 'register.post']) !!}
        @formGroup('name')
            {!! Form::label('name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
            @error('name')
        @endFormGroup

        @formGroup('email')
            {!! Form::label('email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
            @error('email')
        @endFormGroup

        @formGroup('username')
            {!! Form::label('username') !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'required']) !!}
            @error('username')
        @endFormGroup

        @formGroup('password')
            {!! Form::label('password') !!}
            {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
            @error('password')
        @endFormGroup

        <div class="form-group">
            {!! Form::label('password_confirmation') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
        </div>

        @formGroup('g-recaptcha-response')
            {!! Recaptcha::render(['lang' => App::getLocale()]) !!}
            @error('g-recaptcha-response')
        @endFormGroup

        {!! Form::submit('Register', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
@stop
