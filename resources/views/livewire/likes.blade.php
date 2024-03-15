<div class="relative" x-data="{ showLikers: false }">
    @if (strlen($likers))
        <div x-cloak x-show="showLikers">
            <x-tooltip>{{ $likers }} liked this {{ $type }}</x-tooltip>
        </div>
    @endif

    <x-heroicon-o-hand-thumb-up class="{{ $isSidebar ? 'w-6 h-6' : 'w-8 h-8' }}" x-on:mouseover="showLikers = true"
        x-on:mouseout="showLikers = false" />
</div>
