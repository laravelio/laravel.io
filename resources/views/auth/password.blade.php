@php($title = 'Password Reset')

@extends('layouts.small')

@section('small-content')
    <h1 class="text-center">{{ $title }}</h1>
    <p>{{ Session::get('status', 'Please fill in your email address below.') }}</p>

    {!! Form::open(['route' => 'password.forgot.post']) !!}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
        {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
@stop
