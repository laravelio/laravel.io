@title('Password Reset')

@extends('layouts.small')

@section('small-content')
    <p>{{ Session::get('status', 'Please fill in your email address below.') }}</p>

    {!! Form::open(['route' => 'password.forgot.post']) !!}
        @formGroup('email')
            {!! Form::label('email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
            @error('email')
        @endFormGroup

        {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
@endsection
