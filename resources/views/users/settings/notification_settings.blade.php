@title('Notification settings')

<section class="mt-6">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <x-buk-form action="{{ route('settings.notifications.store') }}">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                    <h2 class="text-lg leading-6 font-medium text-gray-900">
                        Notification settings
                    </h2>

                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Enable or disable specific notification types.
                    </p>
                </div>

                <ul class="space-y-3">
                    @foreach (App\Enums\NotificationType::getTypes() as $notificationType)
                        <li>
                            <div>
                                <div class="col-span-12">
                                    @php($checked = auth()->user()->isNotificationAllowed($notificationType->getClass()))

                                    <x-forms.inputs.checkbox
                                        name="allowed_notifications[]"
                                        value="{{ $notificationType->value }}"
                                        id="{{ $notificationType->value }}"
                                        :checked="$checked"
                                    >
                                        {{ $notificationType->label() }}
                                    </x-forms.inputs.checkbox>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-buttons.primary-button type="submit">
                    Save notification settings
                </x-buttons.primary-button>
            </div>
        </x-buk-form>
    </div>
</section>
