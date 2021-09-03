<div class="flex flex-col gap-y-6">
    @forelse ($user->latestReplies(5) as $reply)
        <x-users.reply :thread="$reply->replyAble()" :reply="$reply" />
    @empty
        <x-empty-state title="{{ $user->username() }} has not posted any replies yet" icon="heroicon-o-annotation" />
    @endforelse
</div>
