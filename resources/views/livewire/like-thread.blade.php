<div>
    @if (Auth::guest())
        <div class="flex items-center gap-x-2">
            <livewire:likes :subject="$this->thread" type="thread" />

            <span class="font-medium">
                {{ count($this->thread->likes()) }}
            </span>
        </div>
    @else
        <button type="button" wire:click="toggleLike" class="flex items-center gap-x-2 text-lio-500">
            <livewire:likes :subject="$this->thread" type="thread" />

            <span class="font-medium">
                {{ count($this->thread->likes()) }}
            </span>

            @if ($this->thread->isLikedBy(Auth::user()))
                <span class="ml-1 text-sm italic text-gray-400">You liked this thread</span>
            @endif
        </button>
    @endif
</div>
