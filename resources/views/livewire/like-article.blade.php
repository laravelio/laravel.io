<div>
    @guest
        <div class="{{ $isSidebar ? 'flex-col' : 'flex-row' }} flex items-center gap-x-4 gap-y-2.5 text-gray-900">
            <livewire:likes :subject="$this->article" :isSidebar="$isSidebar" type="article" />
            <span class="{{ $isSidebar ? 'text-base' : 'text-2xl' }} font-medium leading-none">
                {{ count($this->article->likes()) }}
            </span>
        </div>
    @else
        <button
            class="{{ $isSidebar ? 'flex-col' : 'flex-row' }} {{ $article->isLikedBy(Auth::user()) ? 'text-lio-500' : 'text-gray-900' }} flex items-center gap-x-4 gap-y-2.5 text-gray-900"
            tag="button"
            wire:click="toggleLike"
        >
            <livewire:likes :subject="$this->article" :isSidebar="$isSidebar" type="article" />
            <span class="{{ $isSidebar ? 'text-base' : 'text-2xl' }} font-medium leading-none">
                {{ count($this->article->likes()) }}
            </span>
        </button>
    @endGuest
</div>
