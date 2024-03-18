@title('Settings')

@extends('layouts.base')

@section('body')
    <div class="bg-gray-50">
        <div class="border-b bg-white">
            <div
                class="container mx-auto flex items-center justify-between px-4"
            >
                <h1 class="py-4 text-xl text-gray-900">Settings</h1>
            </div>
        </div>

        @include('layouts._alerts')

        <main class="mx-auto max-w-5xl px-4 pb-12 pt-10 lg:pb-16">
            <div class="lg:grid lg:grid-cols-4 lg:gap-x-5">
                <div class="sm:px-6 lg:col-span-1 lg:px-0">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <nav class="space-y-1" aria-label="Sidebar">
                        <a
                            href="#profile_settings_heading"
                            class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                        >
                            <x-heroicon-o-user
                                class="-ml-1 mr-3 h-6 w-6 flex-shrink-0 text-gray-400"
                            />
                            <span class="truncate">Profile</span>
                        </a>
                        <a
                            href="#password_settings_heading"
                            class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                        >
                            <x-heroicon-o-key
                                class="-ml-1 mr-3 h-6 w-6 flex-shrink-0 text-gray-400"
                            />
                            <span class="truncate">Password</span>
                        </a>
                        <a
                            href="#api_token_settings_heading"
                            class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                        >
                            <x-heroicon-o-code-bracket
                                class="-ml-1 mr-3 h-6 w-6 flex-shrink-0 text-gray-400"
                            />
                            <span class="truncate">API Tokens</span>
                        </a>
                        <a
                            href="#list_blocked_users"
                            class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                        >
                            <x-heroicon-o-x-mark
                                class="-ml-1 mr-3 h-6 w-6 flex-shrink-0 text-gray-400"
                            />
                            <span class="truncate">Blocked Users</span>
                        </a>

                        @unless (Auth::user()->isAdmin())
                            <a
                                href="#remove_account_heading"
                                class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                            >
                                <x-heroicon-o-trash
                                    class="-ml-1 mr-3 h-6 w-6 flex-shrink-0 text-gray-400"
                                />
                                <span class="truncate">Remove Account</span>
                            </a>
                        @endunless
                    </nav>
                </div>
                <div class="mt-10 sm:px-6 lg:col-span-3 lg:mt-0 lg:px-0">
                    @include('users.settings.profile')
                    @include('users.settings.password')
                    @include('users.settings.api_tokens')
                    @include('users.settings.notification_settings')
                    @include('users.settings.blocked')
                    @include('users.settings.remove')
                </div>
            </div>
        </main>
    </div>
@endsection
