@title('Password Reset')

@extends('layouts.small')

@section('small-content')
    <p class="mb-4">{{ Session::get('status', 'Please fill in your email address below.') }}</p>

    <form action="{{ route('password.forgot.post') }}" method="POST" class="w-full">
        @csrf

        @formGroup('email')
            <label for="email" name="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required />
            @error('email')
        @endFormGroup

        <button type="submit" class="w-full button button-primary">Send Password Reset Link</button>
    </form>
@endsection
