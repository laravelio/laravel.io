<div
    class="flex flex-col gap-x-4 gap-y-3 lg:flex-row lg:justify-between"
    x-data="{ hovered: false }"
>
    <div class="flex flex-col gap-x-4 gap-y-3 lg:flex-row">
        @if (Auth::check() && $article->isAuthoredBy(Auth::user()))
            <x-buttons.secondary-button
                href="{{ route('articles.edit', $article->slug()) }}"
                @mouseover="hovered = 'edit'"
                @mouseleave="hovered = false"
                class="w-full"
            >
                <span class="flex items-center gap-x-2">
                    <x-heroicon-o-pencil class="w-5 h-5" title="Edit" />
                    <span x-cloak x-show="hovered === 'edit'" class="leading-5">Edit article</span>
                </span>
            </x-buttons.primary-menu-button>
        @endif

        @if ($article->isNotPublished() && $article->isAwaitingApproval())
            @can(App\Policies\ArticlePolicy::APPROVE, $article)
                <x-buttons.secondary-button
                    tag="button"
                    @click.prevent="activeModal = 'approveArticle'"
                    @mouseover="hovered = 'publish'"
                    @mouseleave="hovered = false"
                    class="w-full"
                >
                    <span class="flex items-center gap-x-2">
                        <x-heroicon-s-check class="w-5 h-5" title="Publish"/>
                        <span x-cloak x-show="hovered === 'publish'" class="leading-5">Publish article</span>
                    </span>
                </x-buttons.secondary-button>
            @endcan

            @can(App\Policies\ArticlePolicy::DECLINE, $article)
                <x-buttons.secondary-button
                    tag="button"
                    @click.prevent="activeModal = 'declineArticle'"
                    @mouseover="hovered = 'decline'"
                    @mouseleave="hovered = false"
                    class="w-full"
                >
                    <span class="flex items-center gap-x-2">
                        <x-heroicon-s-x class="w-5 h-5" title="Decline"/>
                        <span x-cloak x-show="hovered === 'decline'" class="leading-5">Decline article</span>
                    </span>
                </x-buttons.secondary-button>
            @endcan
        @else
            @can(App\Policies\ArticlePolicy::DISAPPROVE, $article)
                <x-buttons.secondary-button
                    tag="button"
                    @click.prevent="activeModal = 'unpublishArticle'"
                    @mouseover="hovered = 'unpublish'"
                    @mouseleave="hovered = false"
                    class="w-full"
                >
                    <span class="flex items-center gap-x-2">
                        <x-heroicon-o-eye-off class="w-5 h-5" title="Unpublish"/>
                        <span x-cloak x-show="hovered === 'unpublish'" class="leading-5">Unpublish article</span>
                    </span>
                </x-buttons.secondary-button>
            @endcan
        @endif

        @can(App\Policies\ArticlePolicy::PINNED, $article)
            <x-buttons.secondary-button
                tag="button"
                @click.prevent="activeModal = 'togglePinnedStatus'"
                @mouseover="hovered = 'pin'"
                @mouseleave="hovered = false"
                :selected="$article->isPinned()"
                class="w-full"
            >
                <span class="flex items-center gap-x-2">
                    <x-icon-pin class="w-5 h-5" title="{{ $article->isPinned() ? 'Unpin' : 'Pin' }}"/>
                    <span x-cloak x-show="hovered === 'pin'" class="leading-5">{{ $article->isPinned() ? 'Unpin article' : 'Pin article' }}</span>
                </span>
            </x-buttons.secondary-button>
        @endcan
    </div>

    @can(App\Policies\ArticlePolicy::DELETE, $article)
        <x-buttons.danger-button
            tag="button"
            @click.prevent="activeModal = 'deleteArticle'"
            @mouseover="hovered = 'delete'"
            @mouseleave="hovered = false"
            class="w-full"
        >
            <span class="flex items-center gap-x-2">
                <x-heroicon-o-trash class="w-5 h-5" title="Delete"/>
                <span x-cloak x-show="hovered === 'delete'" class="leading-5">Delete article</span>
            </span>
        </x-buttons.danger-button>
    @endcan
</div>

