@title('Settings')

@extends('layouts.base')

@section('body')
    <div class="bg-gray-50">
        <div class="bg-white border-b">
            <div class="container mx-auto flex justify-between items-center px-4">
                <h1 class="text-xl py-4 text-gray-900">Settings</h1>
            </div>
        </div>

        @include('layouts._alerts')

        <main class="max-w-5xl mx-auto pt-10 pb-12 px-4 lg:pb-16">
            <div class="lg:grid lg:gap-x-5 lg:grid-cols-4">
                <div class="sm:px-6 lg:px-0 lg:col-span-1">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <nav class="space-y-1" aria-label="Sidebar">
                        <a href="#profile_settings_heading" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            <x-heroicon-o-user class="text-gray-400 flex-shrink-0 -ml-1 mr-3 h-6 w-6" />
                            <span class="truncate">Profile</span>
                        </a>
                        <a href="#password_settings_heading" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            <x-heroicon-o-key class="text-gray-400 flex-shrink-0 -ml-1 mr-3 h-6 w-6" />
                            <span class="truncate">Password</span>
                        </a>
                        <a href="#api_token_settings_heading" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            <x-heroicon-o-code-bracket class="text-gray-400 flex-shrink-0 -ml-1 mr-3 h-6 w-6" />
                            <span class="truncate">API Tokens</span>
                        </a>
                        <a href="#list_blocked_users" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            <x-heroicon-o-x-mark class="text-gray-400 flex-shrink-0 -ml-1 mr-3 h-6 w-6" />
                            <span class="truncate">Blocked Users</span>
                        </a>

                        @unless (Auth::user()->isAdmin())
                            <a href="#remove_account_heading" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 flex items-center px-3 py-2 text-sm font-medium rounded-md">
                                <x-heroicon-o-trash class="text-gray-400 flex-shrink-0 -ml-1 mr-3 h-6 w-6" />
                                <span class="truncate">Remove Account</span>
                            </a>
                        @endunless
                    </nav>
                </div>
                <div class="mt-10 lg:mt-0 sm:px-6 lg:px-0 lg:col-span-3">
                    @include('users.settings.profile')
                    @include('users.settings.password')
                    @include('users.settings.api_tokens')
                    @include('users.settings.blocked')
                    @include('users.settings.remove')
                </div>
            </div>
        </main>
    </div>
@endsection
