@unless (Auth::user()->isAdmin())
    <section aria-labelledby="remove_account_heading" class="mt-6">
        <div class="shadow sm:overflow-hidden sm:rounded-md">
            <div class="space-y-6 bg-white px-4 py-6 sm:p-6">
                <div>
                    <h2 id="remove_account_heading" class="text-lg font-medium uppercase leading-6 text-red-500">
                        Danger Zone
                    </h2>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Please be aware that deleting your account will also remove all of your data, including your
                        threads and replies. This cannot be undone.
                    </p>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                <span class="inline-flex rounded-md shadow-sm">
                    <x-buttons.danger-button @click.prevent="activeModal = 'deleteAccount'">
                        Delete Account
                    </x-buttons.danger-button>
                </span>
            </div>
        </div>
    </section>

    <x-modal
        identifier="deleteAccount"
        :action="route('settings.profile.delete')"
        title="Delete Account"
        submitLabel="Confirm"
    >
        <p>Deleting your account will remove any related content like threads & replies. This cannot be undone.</p>
    </x-modal>
@endunless
