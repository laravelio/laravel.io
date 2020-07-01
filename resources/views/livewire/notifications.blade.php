<div>
    @if ($notifications->count())
        <div class="flex flex-col bg-white">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
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
