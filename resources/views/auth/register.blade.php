@title('Register')

@extends('layouts.small')

@section('small-content')
    @if (! session()->has('githubData'))
        <p class="mb-4">To register, we require you to login with your Github account. After login you can choose your password in the settings screen.</p>

        <a href="{{ route('login.github') }}" class="button button-dark">
            <i class="fa fa-github"></i> Github
        </a>
    @else
        {!! Form::open(['route' => 'register.post']) !!}
            @formGroup('name')
                {!! Form::label('name') !!}
                {!! Form::text('name', session('githubData.name'), ['class' => 'form-control', 'required', 'placeholder' => 'John Doe']) !!}
                @error('name')
            @endFormGroup

            @formGroup('email')
                {!! Form::label('email') !!}
                {!! Form::email('email', session('githubData.email'), ['class' => 'form-control', 'required', 'placeholder' => 'john@example.com']) !!}
                @error('email')
            @endFormGroup

            @formGroup('username')
                {!! Form::label('username') !!}
                {!! Form::text('username', session('githubData.username'), ['class' => 'form-control', 'required', 'placeholder' => 'johndoe']) !!}
                @error('username')
            @endFormGroup

            @formGroup('rules')
                <label>
                    {!! Form::checkbox('rules') !!}
                    &nbsp; I agree to <a href="{{ route('rules') }}" target="_blank">the rules of the portal</a>
                </label>
                @error('rules')

                <label>
                    {!! Form::checkbox('terms') !!}
                    &nbsp; I agree to <a href="{{ route('terms') }}" target="_blank">Terms & Conditions</a> and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>.
                </label>
                @error('terms')
            @endFormGroup

            {!! Form::hidden('github_id', session('githubData.id')) !!}
            {!! Form::hidden('github_username', session('githubData.username')) !!}
            {!! Form::submit('Register', ['class' => 'w-full button button-primary']) !!}
        {!! Form::close() !!}
    @endif
@endsection
