<div>
    @if (Auth::guest())
        <div class="flex items-center gap-x-2">
            <livewire:likes :subject="$this->reply" type="reply" />

            <span class="font-medium">
                {{ count($this->reply->likes()) }}
            </span>
        </div>
    @else
        <button type="button" wire:click="toggleLike" class="flex items-center gap-x-2 text-lio-500">
            <livewire:likes :subject="$this->reply" type="reply" />

            <span class="font-medium">
                {{ count($this->reply->likes()) }}
            </span>

            @if ($this->reply->isLikedBy(Auth::user()))
                <span class="ml-1 text-sm italic text-gray-400">You liked this reply</span>
            @endif
        </button>
    @endif
</div>
