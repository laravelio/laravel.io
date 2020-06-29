@title('Register')

@extends('layouts.small')

@section('small-content')
    @if (! session()->has('githubData'))
        <p class="mb-4">To register, we require you to login with your Github account. After login you can choose your password in the settings screen.</p>

        <a href="{{ route('login.github') }}" class="button button-dark">
            <span class="flex items-center justify-center">
                <x-icon-github class="inline h-5 w-5 mr-2" />
                Github
            </span>
        </a>
    @else
        <form action="{{ route('register.post') }}" method="POST" class="w-full">
            @csrf
        
            @formGroup('name')
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ session('githubData.name') }}" class="form-control" required placeholder="John Doe" />
                @error('name')
            @endFormGroup

            @formGroup('email')
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ session('githubData.email') }}" class="form-control" required placeholder="john@example.com" />
                @error('email')
            @endFormGroup

            @formGroup('username')
                <label for="username">Username</label>
                <input type="text" name="username" value="{{ session('githubData.username') }}" class="form-control" required placeholder="johndoe" />
                @error('username')
            @endFormGroup

            @formGroup('rules')
                <label>
                    <input type="checkbox" name="rules" value="1" />
                    &nbsp; I agree to <a href="{{ route('rules') }}" target="_blank">the rules of the portal</a>
                </label>
                @error('rules')

                <label>
                    <input type="checkbox" name="terms" value="1" />
                    &nbsp; I agree to <a href="{{ route('terms') }}" target="_blank">Terms & Conditions</a> and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>.
                </label>
                @error('terms')
            @endFormGroup

            <input type="hidden" name="github_id" value="{{ session('githubData.id') }}" />
            <input type="hidden" name="github_username" value="{{ session('githubData.username') }}" />

            <button type="submit" class="w-full button button-primary">Register</button>
        </form>
    @endif
@endsection
