@title('Login')

@extends('layouts.small')

@section('small-content')
    {!! Form::open(['route' => 'login.post', 'class' => 'w-full']) !!}

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
            <label>
                {!! Form::checkbox('remember') !!}
                Remember login
            </label>
        </div>

        {!! Form::submit('Login', ['class' => 'w-full button mb-4']) !!}
        <a href="{{ route('login.github') }}" class="button button-dark mb-4">
            <i class="fa fa-github mr-1"></i> Github
        </a>
    {!! Form::close() !!}
@endsection

@section('small-content-after')
    <a href="{{ route('password.forgot') }}" class="block text-center text-green-darker">Forgot your password?</a>
@endsection
