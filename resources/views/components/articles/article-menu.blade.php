@props(['article'])

<div class="flex items-center gap-x-3">
    <div
        class="relative -mr-3"
        x-data="{ open: false }"
        @click.outside="open = false"
    >
        <button class="rounded p-2 hover:bg-gray-100" @click="open = !open">
            <x-heroicon-o-ellipsis-horizontal class="h-6 w-6" />
        </button>

        <div
            x-cloak
            x-show="open"
            class="absolute right-1 top-12 flex w-48 flex-col rounded bg-white shadow"
        >
            @can(App\Policies\ArticlePolicy::UPDATE, $article)
                <a
                    class="flex gap-x-2 rounded p-3 hover:bg-gray-100"
                    href="{{ route('articles.edit', $article->slug()) }}"
                >
                    <x-heroicon-o-pencil class="h-6 w-6" />
                    Edit
                </a>
            @endcan

            <a
                class="flex gap-x-2 rounded p-3 hover:bg-gray-100"
                href="{{ route('articles.show', $article->slug()) }}"
            >
                <x-heroicon-o-eye class="h-6 w-6" />
                View
            </a>
        </div>
    </div>
</div>
