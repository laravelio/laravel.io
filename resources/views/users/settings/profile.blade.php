@title('Profile')

<section aria-labelledby="profile_settings_heading">
    <x-form method="PUT" action="{{ route('settings.profile.update') }}">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">

                <div>
                    <h2 id="profile_settings_heading" class="text-lg leading-6 font-medium text-gray-900">Profile</h2>
                    <p class="mt-1 text-sm leading-5 text-gray-500">Update your profile information.</p>
                </div>

                <div class="flex flex-col space-y-6 lg:flex-row lg:space-y-0 lg:space-x-6">
                    <div class="flex-grow space-y-6">
                        <div class="space-y-1">
                            <x-label for="name">Name</x-label>
                            <x-input name="name" value="{{ Auth::user()->name() }}" required />
                        </div>

                        <div class="space-y-1">
                            <x-label for="bio">Bio</x-label>
                            <x-textarea name="bio" rows="3" maxlength="160">
                                {{ Auth::user()->bio() }}
                            </x-textarea>
                            <span class="mt-2 text-sm text-gray-500">The user bio is limited to 160 characters.</span>
                        </div>
                    </div>
                    <div class="flex-grow space-y-1 lg:flex-grow-0 lg:flex-shrink-0">
                        <p class="block text-sm leading-5 font-medium text-gray-700" aria-hidden="true">
                            Profile Image
                        </p>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 inline-block overflow-hidden" aria-hidden="true">
                                <x-avatar search="{{ Auth::user()->emailAddress() }}" provider="gravatar" class="rounded-full h-32 w-32" />
                                <span class="mt-2 text-sm text-gray-500">Change your avatar on <a href="https://gravatar.com/" class="text-lio-700">Gravatar</a>.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 sm:col-span-6">
                        <x-label for="email">Email</x-label>
                        <x-input type="email" name="email" value="{{ Auth::user()->emailAddress() }}" required />
                        @unless(Auth::user()->hasVerifiedEmail())
                            <span class="mt-2 text-sm text-gray-500">
                                This email address is not verified yet.
                                <a href="{{ route('verification.notice') }}" class="text-lio-500">Resend verification email.</a>
                            </span>
                        @endunless
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-label for="username">Username</x-label>
                        <x-input name="username" value="{{ Auth::user()->username() }}" required />
                    </div>

                </div>
                
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <span class="inline-flex rounded-md shadow-sm">
                    <x-primary-button type="submit">
                        Update Profile
                    </x-primary-button>
                </span>
            </div>

        </div>
    </x-form>
</section>
