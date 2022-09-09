@props(['article'])

<div class="flex items-center gap-x-3">
    <div class="relative -mr-3" x-data="{ open: false }" @click.outside="open = false">
        
        <button 
            class="p-2 rounded hover:bg-gray-100" 
            @click="open = !open"    
        >
            <x-heroicon-o-ellipsis-horizontal class="w-6 h-6" />
        </button>

        <div 
            x-cloak 
            x-show="open" 
            class="absolute top-12 right-1 flex flex-col bg-white rounded shadow w-48"
        >                

            @can(App\Policies\ArticlePolicy::UPDATE, $article)
                <a class="flex gap-x-2 p-3 rounded hover:bg-gray-100" href="{{ route('articles.edit', $article->slug()) }}">
                    <x-heroicon-o-pencil class="w-6 h-6"/>
                    Edit
                </a>
            @endcan

            <a class="flex gap-x-2 p-3 rounded hover:bg-gray-100" href="{{ route('articles.show', $article->slug()) }}">
                <x-heroicon-o-eye class="w-6 h-6"/>
                View
            </a>
        </div>
    </div>
</div>
