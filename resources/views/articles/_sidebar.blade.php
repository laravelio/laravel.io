<div class="flex md:flex-col items-center justify-center md:justify-start text-gray-500">
    @if (Auth::check() && $article->isAuthoredBy(Auth::user()))
        <x-buttons.primary-menu-button href="{{ route('articles.edit', $article->slug()) }}">
            <x-heroicon-o-pencil class="w-6 h-6" title="Edit" />
        </x-buttons.primary-menu-button>
    @endif

    @if ($article->isNotPublished() && $article->isAwaitingApproval())
        @can(App\Policies\ArticlePolicy::APPROVE, $article)
            <x-buttons.primary-menu-button tag="button" @click.prevent="activeModal = 'approveArticle'">
                <x-heroicon-o-check class="w-6 h-6" title="Approve"/> 
            </x-buttons.primary-menu-button>
        @endcan
    @else
        @can(App\Policies\ArticlePolicy::DISAPPROVE, $article)
            <x-buttons.danger-menu-button tag="button" @click.prevent="activeModal = 'disapproveArticle'">
                <x-heroicon-o-ban class="w-6 h-6" title="Disapprove"/>
            </x-buttons.danger-menu-button>
        @endcan
    @endif

    @can(App\Policies\ArticlePolicy::DELETE, $article)
        <x-buttons.danger-menu-button tag="button" @click.prevent="activeModal = 'deleteArticle'">
            <x-heroicon-o-trash class="w-6 h-6" title="Delete"/> 
        </x-buttons.danger-menu-button>
    @endcan

    @can(App\Policies\ArticlePolicy::PINNED, $article)
        <x-buttons.primary-menu-button tag="button" @click.prevent="activeModal = 'togglePinnedStatus'" :selected="$article->isPinned()">
            <x-zondicon-pin class="w-6 h-6" title="{{ $article->isPinned() ? 'Unpin' : 'Pin' }}"/> 
        </x-buttons.primary-menu-button>
    @endcan

    <livewire:like-article :article="$article" />
</div>