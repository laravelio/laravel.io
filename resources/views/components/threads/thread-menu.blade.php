@props(['thread'])

@canany([App\Policies\ThreadPolicy::UPDATE, App\Policies\ThreadPolicy::DELETE], $thread)
    <div class="flex items-center gap-x-3">
        <div class="relative -mr-3" x-data="{ open: false }" @click.away="open = false">
            
            <button 
                class="p-2 rounded hover:bg-gray-100" 
                @click="open = !open"    
            >
                <x-heroicon-o-dots-horizontal class="w-6 h-6" />
            </button>

            <div 
                x-cloak 
                x-show="open" 
                class="absolute top-12 right-1 flex flex-col bg-white rounded shadow w-48"
            >                

                @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                    <a class="flex gap-x-2 p-3 rounded hover:bg-gray-100" href="{{ route('threads.edit', $thread->slug()) }}">
                        <x-heroicon-o-pencil class="w-6 h-6"/>
                        Edit
                    </a>
                @endcan

                @can(App\Policies\ThreadPolicy::DELETE, $thread)
                    <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100" @click="$dispatch('open-modal', 'delete-thread')">
                        <x-heroicon-o-trash class="w-6 h-6 text-red-500"/>
                        Delete
                    </button>
                @endcan
            </div>
        </div>
    </div>

    @include('_partials._delete_modal', [
        'identifier' => 'delete-thread',
        'route' => ['threads.delete', $thread->slug()],
        'title' => 'Delete Thread',
        'body' => '<p>Are you sure you want to delete this thread and its replies? This cannot be undone.</p>',
    ])
@endcanany