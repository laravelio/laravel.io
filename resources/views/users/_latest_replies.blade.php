<div class="flex flex-col gap-y-6">
    @forelse ($replies as $reply)
        <x-users.reply :thread="$reply->replyAble()" :reply="$reply" />
    @empty
        <x-empty-state title="{{ $user->username() }} has not posted any replies yet" icon="heroicon-o-chat-bubble-bottom-center-text" />
    @endforelse

    @if ($replies->hasPages())
        <div class="mt-8">
            {{ $replies->onEachSide(1)->links() }}
        </div>
    @endif
</div>
