@props([
    'thread',
])

<div class="h-full rounded shadow-lg p-5 bg-white">
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
        <div>
            <div class="flex flex-wrap items-center space-x-1 text-sm">
                <div class="flex items-center">
                    <x-avatar :user="$thread->author()" class="w-6 h-6 rounded-full mr-2" />

                    <a href="{{ route('profile', $thread->author()->username()) }}" class="hover:underline">
                        <span class="text-gray-900 font-semibold">{{ $thread->author()->username() }}</span>
                    </a>
                </div>

                <span class="text-gray-700">posted</span>

                <span class="text-gray-700">
                    {{ $thread->createdAt()->diffForHumans() }}
                </span>
            </div>
        </div>

        @if (count($tags = $thread->tags()))
            <div class="flex flex-wrap gap-2 mt-2 lg:mt-0 lg:gap-x-4">
                @foreach ($tags as $tag)
                    <a href="{{ route('forum.tag', $tag->slug()) }}" class="flex gap-2">
                        <x-tag>
                            {{ $tag->name() }}
                        </x-tag>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-3 break-words">
        <h3 class="text-xl text-gray-900 font-semibold">
            <a
                href="{{ route('thread', $thread->slug()) }}"
                class="hover:underline"
            >{{ $thread->subject() }}</a>

            @if ($thread->isLocked())
                <x-heroicon-o-lock-closed class="w-4 h-4 mb-1 inline-block" />
            @endif
        </h3>

        <p class="text-gray-800 leading-7 mt-1">
            {!! $thread->excerpt() !!}
        </p>
    </div>

    <div class="flex justify-between items-center mt-4">
        <div class="flex gap-x-5">
            <span class="flex items-center gap-x-2">
                <x-heroicon-o-hand-thumb-up class="w-6 h-6" />
                <span>{{ $thread->like_count }}</span>
                <span class="sr-only">Likes</span>
            </span>

            <span class="flex items-center gap-x-2">
                <x-heroicon-o-chat-bubble-left-right class="w-6 h-6" />
                <span>{{ $thread->reply_count }}</span>
                <span class="sr-only">Replies</span>
            </span>
        </div>

        @if ($thread->isSolved())
            <a
                href="{{ route('thread', $thread->slug()) }}#{{ $thread->solution_reply_id }}"
                class="flex items-center gap-x-2 font-medium text-lio-500"
            >
                <x-heroicon-o-check-badge class="w-6 h-6" />
                <span class="hover:underline">Solved</span>
            </a>
        @endif
    </div>
</div>
