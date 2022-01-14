@title('Password Reset')

@extends('layouts.small')

@section('small-content')
    <p class="mb-4">{{ Session::get('status', 'Please fill in your email address below.') }}</p>

    <x-buk-form action="{{ route('password.forgot.post') }}" method="POST" class="space-y-6">
        <div>
            <x-forms.label for="email" />

            <x-forms.inputs.email name="email" id="email" required />
        </div>

        <x-buttons.primary-button type="submit" fullWidth>
            Send Password Reset Link
        </x-buttons.primary-button>
    </x-buk-form>
@endsection
