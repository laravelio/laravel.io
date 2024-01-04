<div>
    @if ($showLikers)
        <x-tooltip>{{ $likers }} liked this article</x-tooltip>
    @endif
        
    <x-heroicon-o-hand-thumb-up class="{{ $isSidebar ? 'w-6 h-6' : 'w-8 h-8' }}" wire:mouseover="toggleLikers" wire:mouseout="toggleLikers" />
</div>