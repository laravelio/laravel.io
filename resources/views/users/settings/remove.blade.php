@unless (Auth::user()->isAdmin())
    <section aria-labelledby="remove_account_heading" class="mt-6">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                    <h2 id="remove_account_heading" class="text-lg leading-6 font-medium text-red-500 uppercase">Danger Zone</h2>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Please be aware that deleting your account will also remove all of your data, including your threads and replies. This cannot be undone.
                    </p>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
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