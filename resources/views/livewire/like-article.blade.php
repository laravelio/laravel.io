<div>
    @guest
        <div class="text-gray-600 mr-2 py-2 inline-block flex items-center">
            <span class="text-3xl mr-3">👏</span>
            {{ $this->article->likesCount() }}
        </div>
    @else
        <button type="button" wire:click="toggleLike" class="text-green-dark mr-2 py-2 flex items-center">
            <span class="text-3xl mr-3">👏</span>
            {{ $this->article->likesCount() }}
        </button>
    @endGuest
</div>
