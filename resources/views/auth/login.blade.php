@extends('layouts.default')

@section('content')
    {!! Form::open(['route' => 'login.post']) !!}
        {!! Form::text('username') !!}<br>
        {{ $errors->first('username') }}<br>
        {!! Form::password('password') !!}<br>
        {{ $errors->first('password') }}<br>
        {!! Form::submit('Login') !!}
    {!! Form::close() !!}
@stop
