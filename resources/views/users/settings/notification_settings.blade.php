@title('Notification settings')

<section aria-labelledby="notification_settings_heading" class="mt-6">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <div>
                <h2 id="notification_settings_heading" class="text-lg leading-6 font-medium text-gray-900">
                    Notification settings
                </h2>

                <p class="mt-1 text-sm leading-5 text-gray-500">
                    By checking or checking out and checkboxes below you can switch on or off according notifications
                </p>
            </div>

            <ul class="space-y-3">
                @foreach (\App\Enums\NotificationTypes::getTypes() as $notification_type => $notification_label)
                    <li>
                        <div>
                            <div class="col-span-12">
                                <x-forms.inputs.checkbox name="{{ $notification_type }}" form="notification_settings_form" id="{{ $notification_type }}">
                                    {{ $notification_label }}
                                </x-forms.inputs.checkbox>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <x-buk-form id="notification_settings_form" method="POST" action="{{ route('settings.api-tokens.store') }}">
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-buttons.primary-button type="submit">
                    Save notification settings
                </x-buttons.primary-button>
            </div>
        </x-buk-form>
    </div>
</section>
