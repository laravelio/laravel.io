@title('Verify Email')

@extends('layouts.small')

@section('small-content')
    <p class="mb-4">Before proceeding, please check your email for a verification link.</p>

    <p class="mb-4">If you did not receive the email, click below to request another.</p>

    <form action="{{ route('verification.resend') }}" method="POST" class="w-full">
        @csrf

        <button type="submit" class="w-full button button-primary">Request Another</button>
    </form>
@endsection
