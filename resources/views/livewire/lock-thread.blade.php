<div class="flex flex-col items-center text-lio-500">
    @if ($thread->isUnlocked())
        @can(App\Policies\ThreadPolicy::LOCK, $thread)
            <x-heroicon-o-lock-open wire:click="toggleLock" class="w-6 h-6 cursor-pointer"/>
        @endif
    @else
        @can(App\Policies\ThreadPolicy::LOCK, $thread)
            <x-heroicon-o-lock-closed wire:click="toggleLock" class="w-6 h-6 cursor-pointer"/>
        @else
            <x-heroicon-o-lock-closed class="w-6 h-6"/>
        @endif

        <p>
            Locked by
            <a href="{{ route('profile', $lockedBy) }}" class="font-bold">
                {{ '@'.$lockedBy }}
            </a>
        </p>
    @endif
</div>
