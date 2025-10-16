@title('GitHub')

<section aria-labelledby="github_settings_heading" class="mt-6">
    <div class="shadow-sm sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h2 id="github_settings_heading" class="text-lg leading-6 font-medium text-gray-900">
                    GitHub Account
                </h2>

                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Connect your GitHub account to keep your profile for easy login and avatar sync.
                </p>
            </div>

            @if (Auth::user()->hasConnectedGitHubAccount())
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="space-y-1">
                        <span class="block text-sm font-medium text-gray-700">
                            Connected as
                        </span>

                        <a href="https://github.com/{{ Auth::user()->githubUsername() }}" class="text-lio-700 font-semibold"
                            target="_blank" rel="noopener">
                            {{ '@' . Auth::user()->githubUsername() }}
                        </a>
                    </div>

                    @if (Auth::user()->password)
                        <x-forms.form method="POST" action="{{ route('settings.github.disconnect') }}">
                            <x-buttons.danger-button type="submit">
                                Disconnect GitHub
                            </x-buttons.danger-button>
                        </x-forms.form>
                    @else
                        <p class="text-sm text-red-600 mt-2">
                            You must set a password before disconnecting your GitHub account, otherwise, you will not be able to log in again.
                        </p>
                    @endif
                </div>
            @else
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <p class="text-sm text-gray-600">
                        Connecting your GitHub account will automatically populate your GitHub username and use your
                        GitHub profile image.
                    </p>
                </div>
            @endif
        </div>

        @unless (Auth::user()->hasConnectedGitHubAccount())
            <x-forms.form id="github_settings_form" method="POST" action="{{ route('settings.github.connect') }}">
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <x-buttons.primary-button type="submit">
                        Connect GitHub
                    </x-buttons.primary-button>
                </div>
            </x-forms.form>
        @endunless
    </div>
</section>
