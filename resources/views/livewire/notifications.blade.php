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
                <div class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.143 17.082a24.248 24.248 0 0 0 3.844.148m-3.844-.148a23.856 23.856 0 0 1-5.455-1.31 8.964 8.964 0 0 0 2.3-5.542m3.155 6.852a3 3 0 0 0 5.667 1.97m1.965-2.277L21 21m-4.225-4.225a23.81 23.81 0 0 0 3.536-1.003A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6.53 6.53m10.245 10.245L6.53 6.53M3 3l3.53 3.53" />
                    </svg>
                    <span class="mt-2 block text-sm font-semibold text-gray-900">
                        You have no unread notifications
                    </span>
                </div>
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
