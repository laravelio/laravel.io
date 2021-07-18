<div>
    @if (Auth::guest())
        <div class="flex items-center gap-x-2">
            <x-heroicon-o-thumb-up class="w-6 h-6" />
            
            <span class="font-medium">
                {{ count($this->reply->likes()) }}
            </span>
        </div>
    @else 
        <button type="button" wire:click="toggleLike" class="flex items-center gap-x-2 text-lio-500">
            <x-heroicon-o-thumb-up class="w-6 h-6" />
            
            <span class="font-medium">
                {{ count($this->reply->likes()) }}
            </span>
            
            @if ($this->reply->isLikedBy(Auth::user()))
                <span class="text-gray-400 text-sm italic ml-1">You liked this reply</span>
            @endif
        </button>
    @endif
</div>
