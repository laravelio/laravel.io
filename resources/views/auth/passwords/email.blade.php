@title('Password Reset')

@extends('layouts.small')

@section('small-content')
    <p class="mb-4">{{ Session::get('status', 'Please fill in your email address below.') }}</p>

    {!! Form::open(['route' => 'password.forgot.post']) !!}
        @formGroup('email')
            {!! Form::label('email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
            @error('email')
        @endFormGroup

        {!! Form::submit('Send Password Reset Link', ['class' => 'w-full button']) !!}
    {!! Form::close() !!}
@endsection
