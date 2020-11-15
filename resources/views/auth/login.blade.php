@title('Login')

@extends('layouts.small')

@section('small-content')
    <form action="{{ route('login.post') }}" method="POST" class="w-full">
        @csrf

        @formGroup('username')
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required class="form-control" />
            @error('username')
        @endFormGroup

        @formGroup('password')
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required class="form-control" />
            @error('password')
        @endFormGroup

        <div class="form-group">
            <label>
                <input name="remember" type="checkbox" value="1">
                Remember login
            </label>
        </div>

        <button type="submit" class="w-full button button-primary mb-4">Login</button>
        <a href="{{ route('login.github') }}" class="button button-dark mb-4">
            <span class="flex items-center justify-center">
                <x-icon-github class="inline h-4 w-4 mr-2" />
                Github
            </span>
        </a>
    </form>
@endsection

@section('small-content-after')
    <a href="{{ route('password.forgot') }}" class="block text-center text-green-700">Forgot your password?</a>
@endsection
