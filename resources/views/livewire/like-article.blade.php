<div>
    @guest
        <div class="flex items-center text-gray-900 gap-x-4 gap-y-2.5 {{ $isSidebar ? 'flex-col' : 'flex-row' }}">
            <livewire:likes :subject="$this->article" :isSidebar="$isSidebar" type="article" />
            <span class="font-medium leading-none {{ $isSidebar ? 'text-base' : 'text-2xl' }}">
                {{ count($this->article->likes()) }}
            </span>
        </div>
    @else
        <button class="flex items-center text-gray-900 gap-x-4 gap-y-2.5 {{ $isSidebar ? 'flex-col' : 'flex-row' }} {{ $article->isLikedBy(Auth::user()) ? 'text-lio-500' : 'text-gray-900' }}" tag="button" wire:click="toggleLike">
            <livewire:likes :subject="$this->article" :isSidebar="$isSidebar" type="article" />
            <span class="font-medium leading-none {{ $isSidebar ? 'text-base' : 'text-2xl' }}">
                {{ count($this->article->likes()) }}
            </span>
        </button>
    @endGuest
</div>
