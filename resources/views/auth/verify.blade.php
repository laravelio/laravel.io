@title('Verify Email')

@extends('layouts.small')

@section('small-content')
    <p class="mb-4">Before proceeding, please check your email for a verification link.</p>

    <p class="mb-4">If you did not receive the email, click below to request another.</p>

    <x-buk-form action="{{ route('verification.resend') }}" method="POST" class="w-full">
        <x-buttons.primary-button type="submit" fullWidth>
            Request Another
        </x-buttons.primary-button>
    </x-buk-form>
@endsection
