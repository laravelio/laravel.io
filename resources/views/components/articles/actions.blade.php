<div class="flex flex-col gap-x-4 gap-y-3 lg:flex-row lg:justify-between">
    <div class="flex flex-col gap-x-4 gap-y-3 lg:flex-row">
        @if (Auth::check() && $article->isAuthoredBy(Auth::user()))
            <x-buttons.secondary-button href="{{ route('articles.edit', $article->slug()) }}" class="w-full">
                <span class="flex items-center gap-x-2">
                    <x-heroicon-o-pencil class="w-5 h-5" title="Edit" />
                    Edit article
                </span>
            </x-buttons.primary-menu-button>
        @endif

        @if ($article->isNotPublished() && $article->isAwaitingApproval())
            @can(App\Policies\ArticlePolicy::APPROVE, $article)
                <x-buttons.secondary-button tag="button" @click.prevent="activeModal = 'approveArticle'" class="w-full">
                    <span class="flex items-center gap-x-2">
                        <x-heroicon-o-eye class="w-5 h-5" title="Publish"/>
                        Publish article
                    </span>
                </x-buttons.secondary-button>
            @endcan
        @else
            @can(App\Policies\ArticlePolicy::DISAPPROVE, $article)
                <x-buttons.secondary-button tag="button" @click.prevent="activeModal = 'disapproveArticle'" class="w-full">
                    <span class="flex items-center gap-x-2">
                        <x-heroicon-o-eye-off class="w-5 h-5" title="Unpublish"/>
                        Unpublish article
                    </span>
                </x-buttons.secondary-button>
            @endcan
        @endif

        @can(App\Policies\ArticlePolicy::PINNED, $article)
            <x-buttons.secondary-button tag="button" @click.prevent="activeModal = 'togglePinnedStatus'" :selected="$article->isPinned()" class="w-full">
                <span class="flex items-center gap-x-2">
                    <x-icon-pin class="w-5 h-5" title="{{ $article->isPinned() ? 'Unpin' : 'Pin' }}"/> 
                    {{ $article->isPinned() ? 'Unpin article' : 'Pin article' }}
                </span>
            </x-buttons.secondary-button>
        @endcan
    </div>

    @can(App\Policies\ArticlePolicy::DELETE, $article)
        <x-buttons.danger-button tag="button" @click.prevent="activeModal = 'deleteArticle'" class="w-full">
            <span class="flex items-center gap-x-2">
                <x-heroicon-o-trash class="w-5 h-5" title="Delete"/>
                Delete article
            </span>
        </x-buttons.danger-button>
    @endcan
</div>

