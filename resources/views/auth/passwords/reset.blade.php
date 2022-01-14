@title('Reset Password')

@extends('layouts.small')

@section('small-content')
    <x-buk-form action="{{ route('password.reset.post') }}" method="POST" class="space-y-6">
        <input type="hidden" name="token" value="{{ $token }}" />

        <div>
            <x-forms.label for="email" />

            <x-forms.inputs.email name="email" id="email" required />
        </div>

        <div>
            <x-forms.label for="password" />

            <x-forms.inputs.password name="password" id="password" required />
        </div>

        <div>
            <x-forms.label for="password_confirmation" />

            <x-forms.inputs.password name="password_confirmation" id="password_confirmation" required />
        </div>

        <x-buttons.primary-button type="submit" fullWidth>
            Reset Password
        </x-buttons.primary-button>
    </x-buk-form>
@endsection
