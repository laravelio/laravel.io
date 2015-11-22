@extends('layouts.default')

@section('content')
    {!! Form::open(['route' => 'password.reset.post']) !!}
        {!! Form::hidden('token', $token) !!}

        <div>
            {!! Form::label('email') !!}<br>
            {!! Form::email('email') !!}<br>
            {{ $errors->first('email') }}<br>
        </div>
        <div>
            {!! Form::label('password') !!}<br>
            {!! Form::password('password') !!}<br>
            {{ $errors->first('password') }}<br>
        </div>
        <div>
            {!! Form::label('password_confirmation') !!}<br>
            {!! Form::password('password_confirmation') !!}<br>
            {{ $errors->first('password_confirmation') }}<br>
        </div>

        <div>
            <button type="submit">
                Reset Password
            </button>
        </div>
    {!! Form::close() !!}
@stop
