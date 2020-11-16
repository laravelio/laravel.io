<div class="thread-info-likes">
    @if (Auth::guest())
        <div class="text-gray-600 px-4 py-2 border-r inline-block">
            <span class="text-2xl mr-1">👍</span>
            {{ $this->reply->likesCount() }}
        </div>
    @else
        <button type="button" wire:click="toggleLike" class="text-lio-600 px-4 py-2 border-r">
            <span class="text-2xl mr-1">👍</span>
            {{ $this->reply->likesCount() }}
        </button>
    @endif
</div>
