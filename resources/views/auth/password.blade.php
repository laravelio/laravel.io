@extends('layouts.default')

@section('content')
    <p>{{ Session::get('status', 'Please fill in your email address below.') }}</p>

    {!! Form::open(['route' => 'password.forgot.post']) !!}
        <div>
            {!! Form::label('email') !!}<br>
            {!! Form::email('email') !!}<br>
            {{ $errors->first('email') }}<br>
        </div>

        <div>
            <button type="submit">
                Send Password Reset Link
            </button>
        </div>
    {!! Form::close() !!}
@stop
