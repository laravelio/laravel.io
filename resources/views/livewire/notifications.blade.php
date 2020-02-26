<div>
    @if($notifications->count())
        <table class="table bg-white">
            <tbody>
                @foreach($notifications as $notification)
                    @includeIf(
                        "users.notifications.{$notification->data['type']}", 
                        ['data' => $notification->data]
                    )
                @endforeach
            </tbody>
        </table>

        {{ $notifications->links() }}
    @else
        <p class="text-gray-600 text-lg">
            You have no unread notifications
        </p>
    @endif
</div>
