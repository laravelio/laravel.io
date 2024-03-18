<div>
    <div
        class="border-b border-gray-200 pb-4 md:flex md:items-center md:justify-between"
    >
        <div class="min-w-0 flex-1">
            <h2
                class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-4xl"
            >
                Notifications

                <span
                    class="rounded-full bg-lio-100 px-3 text-2xl text-lio-500"
                >
                    {{ $notificationCount }}
                </span>
            </h2>
        </div>

        @if ($notificationCount)
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <button
                    @click="activeModal = 'markAllAsRead'"
                    class="inline-flex justify-center rounded border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100"
                >
                    <x-heroicon-s-check class="mr-1 h-5 w-5" />
                    Clear All
                </button>
            </div>
        @endif
    </div>

    <div class="my-4">
        <div class="pb-4">
            @if ($notifications->total())
                <div class="mb-4 flex flex-col bg-white lg:rounded-lg">
                    <div
                        class="overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8"
                    >
                        <div
                            class="inline-block min-w-full overflow-hidden align-middle shadow lg:rounded-lg"
                        >
                            <table class="min-w-full">
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        @includeIf("notifications.{$notification->data['type']}")
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{ $notifications->links() }}
            @else
                <p class="text-base text-gray-600">
                    You have no unread notifications
                </p>
            @endif
        </div>
    </div>

    <x-modal
        identifier="markAllAsRead"
        :action="route('notifications.mark-as-read')"
        title="Confirm"
        type="post"
    >
        <p>Are you sure you want to mark all notifications as read?</p>
    </x-modal>
</div>
