<div>
    <div class="md:flex md:items-center md:justify-between border-b border-gray-200 pb-4">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-4xl sm:truncate">
                Notifications

                <span class="text-2xl text-lio-500 rounded-full bg-lio-100 px-3">
                    {{ $notificationCount }}
                </span>
            </h2>
        </div>

        @if ($notificationCount)
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <button  @click="activeModal = 'markAllAsRead'" class="bg-white border border-gray-200 rounded py-2 px-4 inline-flex justify-center text-sm text-gray-900 hover:bg-gray-100 font-medium">
                    <x-heroicon-s-check class="w-5 h-5 mr-1"/>
                    Clear All
                </button>
            </div>
        @endif
    </div>

    <div class="my-4">
        <div class="pb-4">
            @if ($notifications->total())
                <div class="flex flex-col bg-white mb-4 lg:rounded-lg">
                    <div class="overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div class="align-middle inline-block min-w-full shadow overflow-hidden lg:rounded-lg">
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
                <p class="text-gray-600 text-base">
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
