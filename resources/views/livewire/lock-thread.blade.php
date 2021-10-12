<button wire:click="toggleLock" class="flex justify-between items-center text-lio-500">
    @if($thread->isUnlocked())
        <x-heroicon-o-lock-open class="w-6 h-6"/>
    @else
        <x-heroicon-o-lock-closed class="w-6 h-6"/>
    @endif
</button>
