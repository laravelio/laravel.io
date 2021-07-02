@props([
    'thread',
])

<div class="flex flex-col rounded shadow-lg p-5">
    <div class="flex items-center justify-between mb-2.5">
        <div class="flex items-center">
            <x-avatar :user="$thread->author()" class="w-8 h-8 rounded-full mr-2" />

            <span class="font-heading text-sm text-black">{{ $thread->author()->name() }}</span>
        </div>

        <div>
            <span class="text-sm text-gray-600">
                {{ $thread->createdAt()->diffForHumans() }}
            </span>
        </div>
    </div>

    <div class="flex-auto flex flex-col justify-between">
        <div>
            <h3 class="text-gray-900 text-2xl mb-2 leading-8">
                {{ $thread->subject() }}
            </h3>

            <p class="text-gray-800 text-base leading-7">
                {{ $thread->excerpt() }}
            </p>
        </div>
        <a href="{{ route('thread', $thread->slug()) }}" class="flex items-center text-base text-gray-300">
            <span class="text-gray-700 mr-1">Open thread</span>
            
            <x-heroicon-s-arrow-right class="w-4 h-4 fill-current" />
        </a>
    </div>
</div>