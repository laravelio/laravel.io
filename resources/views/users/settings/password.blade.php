@title('Password')

<section aria-labelledby="password_settings_heading" class="mt-6">
    <x-buk-form method="PUT" action="{{ route('settings.password.update') }}">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                    <h2 id="password_settings_heading" class="text-lg leading-6 font-medium text-gray-900">
                        Password Settings
                    </h2>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Update the password used for logging into your account.
                    </p>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    @if (Auth::user()->hasPassword())
                        <div class="col-span-12">
                            <x-forms.label for="current_password" />

                            <x-forms.inputs.password name="current_password" required />
                        </div>
                    @endif

                    <div class="col-span-12">
                        <x-forms.label for="password">New Password</x-label>

                        <x-forms.inputs.password name="password" required />
                    </div>

                    <div class="col-span-12">
                        <x-forms.label for="password_confirmation">Confirm New Password</x-label>

                        <x-forms.inputs.password name="password_confirmation" required />
                    </div>
                </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-buttons.primary-button type="submit">
                    Update Password
                </x-buttons.primary-button>
            </div>
        </div>
    </x-form>
</section>
