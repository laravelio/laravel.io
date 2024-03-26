@title('Password')

<section aria-labelledby="password_settings_heading" class="mt-6">
    <div class="shadow sm:overflow-hidden sm:rounded-md">
        <div class="space-y-6 bg-white px-4 py-6 sm:p-6">
            <div>
                <h2 id="list_blocked_users" class="text-lg font-medium leading-6 text-gray-900">Blocked Users</h2>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    The users below will not be able to mention you in their forum threads or replies. You can block additional users from their
                    profile. Or you can unblock users below.
                </p>
            </div>

            <ul class="space-y-4">
                @forelse (Auth::user()->blockedUsers as $user)
                    <li class="flex items-center justify-between space-x-2">
                        <div class="flex items-center">
                            <div class="h-10 w-10 shrink-0">
                                <x-avatar :user="$user" class="h-10 w-10 rounded-full" />
                            </div>

                            <div class="ml-4 text-sm text-gray-500">
                                <a href="{{ route('profile', $user->username()) }}">
                                    {{ $user->username() }}
                                </a>
                            </div>
                        </div>

                        <x-buk-form-button action="{{ route('settings.users.unblock', $user->username()) }}" method="PUT">
                            <x-heroicon-s-x-mark class="h-4 w-4 text-gray-500 hover:text-red-500" />
                        </x-buk-form-button>
                    </li>
                @empty
                    <p class="mt-1 text-sm leading-5 text-gray-500">Currently, you've not blocked anyone.</p>
                @endforelse
            </ul>
        </div>
    </div>
</section>
