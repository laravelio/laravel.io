@title('Register')

@extends('layouts.small')

@section('small-content')
    {!! Form::open(['route' => 'register.post']) !!}
        @formGroup('name')
            {!! Form::label('name') !!}
            {!! Form::text('name', session('githubData.name'), ['class' => 'form-control', 'required']) !!}
            @error('name')
        @endFormGroup

        @formGroup('email')
            {!! Form::label('email') !!}
            {!! Form::email('email', session('githubData.email'), ['class' => 'form-control', 'required']) !!}
            @error('email')
        @endFormGroup

        @formGroup('username')
            {!! Form::label('username') !!}
            {!! Form::text('username', session('githubData.username'), ['class' => 'form-control', 'required']) !!}
            @error('username')
        @endFormGroup

        @if (! session()->has('githubData'))
            @formGroup('password')
                {!! Form::label('password') !!}
                {!! Form::password('password', ['class' => 'form-control', Session::has('githubData') ? null : 'required']) !!}
                @error('password')
            @endFormGroup

            <div class="form-group">
                {!! Form::label('password_confirmation') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control', Session::has('githubData') ? null : 'required']) !!}
            </div>
        @endif

        {!! Form::submit('Register', ['class' => 'btn btn-primary btn-block']) !!}

        @if (! session()->has('githubData'))
            <a href="{{ route('login.github') }}" class="btn btn-default btn-block">
                <i class="fa fa-github"></i> Github
            </a>
        @endif
    {!! Form::close() !!}
@endsection
