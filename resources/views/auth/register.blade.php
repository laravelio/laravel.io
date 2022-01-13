@title('Register')

@extends('layouts.small')

@section('small-content')
    @if (! session()->has('githubData'))
        <p class="mb-8">To register, we require you to login with your GitHub account. After login you can choose your password in the settings screen.</p>

        <x-buttons.secondary-button href="{{ route('login.github') }}" fullWidth>
            <span class="flex items-center gap-x-2">
                <x-icon-github class="h-5 w-5 text-gray-500" />
                <span>Sign in with GitHub</span>
            </span>
        </x-buttons.secondary-button>
    @else
        <x-buk-form method="POST" action="{{ route('register.post') }}" class="space-y-6">
            <div>
                <x-forms.label for="name" />

                <x-forms.inputs.input name="name" value="{{ session('githubData.name') }}" placeholder="John Doe" required />
            </div>

            <div>
                <x-forms.label for="email" />

                <x-forms.inputs.email name="email" value="{{ session('githubData.email') }}" placeholder="john@example.com" required />
            </div>

            <div>
                <x-forms.label for="username" />

                <x-forms.inputs.input name="username" value="{{ session('githubData.username') }}" placeholder="johndoe" required />
            </div>

            <div class="flex items-center">
                <x-forms.inputs.checkbox name="rules" id="rules">
                    I agree to <a href="{{ route('rules') }}" target="_blank">the rules of the portal</a>
                </x-forms.inputs.checkbox>
            </div>

            <div class="flex items-center">
                <x-forms.inputs.checkbox name="terms" id="terms">
                    I agree to <a href="{{ route('terms') }}" target="_blank">Terms & Conditions</a> and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>
                </x-forms.inputs.checkbox>
            </div>

            <input type="hidden" name="github_id" value="{{ session('githubData.id') }}" />
            <input type="hidden" name="github_username" value="{{ session('githubData.username') }}" />

            <button type="submit" class="w-full button button-primary">Register</button>
        </x-buk-form>
    @endif
@endsection
