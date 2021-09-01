<div class="flex flex-col gap-y-6">
    @forelse ($user->latestReplies(5) as $reply)
        <x-users.reply :thread="$reply->replyAble()" :reply="$reply" />
    @empty
        <p class="text-gray-600 text-base">
            {{ $user->username() }} has not posted any replies yet
        </p>
    @endforelse
</div>
