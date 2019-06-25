@title('Reset Password')

@extends('layouts.small')

@section('small-content')
    <form action="{{ route('password.reset.post') }}" method="POST" class="w-full">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}" />

        @formGroup('email')
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required />
            @error('email')
        @endFormGroup

        @formGroup('password')
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required />
            @error('password')
        @endFormGroup

        <div class="form-group">
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required />
        </div>

        <input type="submit" class="w-full button button-primary" value="Reset Password"/>
    </form>
@endsection
