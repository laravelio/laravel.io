<div class="flex flex-col gap-y-6">
    @forelse ($threads as $thread)
        <x-threads.overview-summary :thread="$thread" />
    @empty
        <x-empty-state title="{{ $user->username() }} has not posted any threads yet" icon="heroicon-o-document-text" />
    @endforelse

    @if ($threads->hasPages())
        <div class="mt-8">
            {{ $threads->onEachSide(1)->links() }}
        </div>
    @endif
</div>
