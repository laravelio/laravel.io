@props([
    'thread',
])

<div class="h-full rounded shadow-lg p-5 bg-white">
    <div class="flex justify-between items-center">
        <div>
            <div class="flex items-center">
                <x-avatar :user="$thread->author()" class="w-6 h-6 rounded-full mr-3" />

                <span class="text-gray-900 mr-5">{{ $thread->author()->name() }}</span>

                <span class="font-mono text-gray-700">
                    {{ $thread->createdAt()->format('j M, Y \a\t h:i') }}
                </span>
            </div>

            <div>
                
            </div>
        </div>

        @if (count($tags = $thread->tags()))
            <div class="flex gap-x-4">
                @foreach ($tags as $tag)
                    <x-tag>
                        {{ $tag->name() }}
                    </x-tag>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-3">
        <h3 class="text-xl text-gray-900 font-semibold">
            {{ $thread->subject() }}
        </h3>

        <p class="text-gray-800 leading-7 mt-1">
            {{ $thread->excerpt() }}
        </p>
    </div>

    <div class="flex gap-x-5 mt-4">
        <span class="flex items-center gap-x-2">
            <x-heroicon-o-thumb-up class="w-6 h-6" />
            <span>{{ count($thread->likes()) }}</span>
            <span class="sr-only">Likes</span>
        </span>

        <span class="flex items-center gap-x-2">
            <x-heroicon-o-chat-alt-2 class="w-6 h-6" /> 
            <span>{{ count($thread->replies()) }}</span>
            <span class="sr-only">Replies</span>
        </span>
    </div>
</div>
