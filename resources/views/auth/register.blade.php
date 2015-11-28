@extends('layouts.small')

@section('small-content')
    <h1 class="text-center">Signup</h1>
    {!! Form::open(['route' => 'signup.post']) !!}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            {!! Form::label('username') !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
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
        {!! Form::submit('Signup', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
@stop
