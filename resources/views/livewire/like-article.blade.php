<div class="relative">
    @if ($showLikers)
        <div class="absolute bottom-16 -left-3 text-white bg-gray-900 rounded-lg w-96 px-4 py-2">
            {{ $likers }} liked this article
        </div>
    @endif
    @guest
        <div class="flex items-center text-gray-900 gap-x-4 gap-y-2.5 {{ $isSidebar ? 'flex-col' : 'flex-row' }}">
            <x-heroicon-o-hand-thumb-up class="{{ $isSidebar ? 'w-6 h-6' : 'w-8 h-8' }}" />
            <span class="font-medium leading-none {{ $isSidebar ? 'text-base' : 'text-2xl' }}">
                {{ count($this->article->likes()) }}
            </span>
        </div>
    @else
        <button class="flex items-center text-gray-900 gap-x-4 gap-y-2.5 {{ $isSidebar ? 'flex-col' : 'flex-row' }} {{ $article->isLikedBy(Auth::user()) ? 'text-lio-500' : 'text-gray-900' }}" tag="button" wire:click="toggleLike">
            <x-heroicon-o-hand-thumb-up class="{{ $isSidebar ? 'w-6 h-6' : 'w-8 h-8' }}" />
            <span class="font-medium leading-none {{ $isSidebar ? 'text-base' : 'text-2xl' }}">
                {{ count($this->article->likes()) }}
            </span>
        </button>
    @endGuest
</div>
