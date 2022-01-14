@title('Sign in to your account')

@extends('layouts.small')

@section('small-content')
    <x-buk-form action="{{ route('login.post') }}" method="POST" class="space-y-6">
        <div>
            <x-forms.label for="username" />

            <x-forms.inputs.input name="username" id="username" required />
        </div>

        <div>
            <x-forms.label for="password" />

            <x-forms.inputs.password name="password" id="password" required />
        </div>

        <div class="flex items-center justify-between">
            <x-forms.inputs.checkbox name="remember" id="remember">
                Remember me
            </x-forms.inputs.checkbox>

            <div class="text-sm">
                <a href="{{ route('password.forgot') }}" class="font-medium text-lio-600 hover:text-lio-500">
                    Forgot your password?
                </a>
            </div>
        </div>

        <div class="w-full">
            <x-buttons.primary-button type="submit" fullWidth>
                Sign in
            </x-buttons.primary-button>
        </div>
    </x-buk-form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>

            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">
                    Or continue with
                </span>
            </div>
        </div>

        <div class="mt-6">
            <div>
                <x-buttons.secondary-button href="{{ route('login.github') }}" fullWidth>
                    <span class="flex items-center gap-x-2">
                        <x-icon-github class="h-5 w-5 text-gray-500" />
                        <span>Sign in with GitHub</span>
                    </span>
                </x-buttons.secondary-button>
            </div>
        </div>
    </div>
@endsection
