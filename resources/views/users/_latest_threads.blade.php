<div class="flex flex-col gap-y-6">
    @forelse ($user->latestThreads() as $thread)
        <x-threads.overview-summary :thread="$thread" />
    @empty
        <p class="text-gray-600 text-base">
            {{ $user->username() }} has not posted any threads yet
        </p>
    @endforelse
</div>
