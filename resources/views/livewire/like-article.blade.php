<div>
    @guest
        <div class="text-gray-600 mr-2 py-2 inline-block flex items-center">
            <x-heroicon-o-thumb-up class="w-6 h-6" />
            {{ $this->article->likesCount() }}
        </div>
    @else
        <x-buttons.primary-menu-button tag="button" wire:click="toggleLike" :selected="$article->isLikedBy(Auth::user())">
            <x-heroicon-o-thumb-up class="w-6 h-6" />
            {{ $this->article->likesCount() }}
        </x-buttons.primary-menu-button>
    @endGuest
</div>
