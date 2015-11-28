@extends('layouts.small')

@section('small-content')
    <h1 class="text-center">Reset Password</h1>
    {!! Form::open(['route' => 'password.reset.post']) !!}
        {!! Form::hidden('token', $token) !!}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password') !!}
            {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
        </div>
        {!! Form::submit('Reset Password', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
@stop
