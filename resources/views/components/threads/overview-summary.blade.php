@props([
    'thread',
])

<div class="h-full rounded bg-white p-5 shadow-lg">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
            <div class="flex flex-wrap items-center space-x-1 text-sm">
                <div class="flex items-center">
                    <x-avatar
                        :user="$thread->author()"
                        class="mr-2 h-6 w-6 rounded-full"
                    />

                    <a
                        href="{{ route('profile', $thread->author()->username()) }}"
                        class="hover:underline"
                    >
                        <span class="font-semibold text-gray-900">
                            {{ $thread->author()->username() }}
                        </span>
                    </a>
                </div>

                <span class="text-gray-700">posted</span>

                <span class="text-gray-700">
                    {{ $thread->createdAt()->diffForHumans() }}
                </span>
            </div>
        </div>

        @if (count($tags = $thread->tags()))
            <div class="mt-2 flex flex-wrap gap-2 lg:mt-0 lg:gap-x-4">
                @foreach ($tags as $tag)
                    <a
                        href="{{ route('forum.tag', $tag->slug()) }}"
                        class="flex gap-2"
                    >
                        <x-tag>
                            {{ $tag->name() }}
                        </x-tag>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-3 break-words">
        <h3 class="text-xl font-semibold text-gray-900">
            <a
                href="{{ route('thread', $thread->slug()) }}"
                class="hover:underline"
            >
                {{ $thread->subject() }}
            </a>

            @if ($thread->isLocked())
                <x-heroicon-o-lock-closed class="mb-1 inline-block h-4 w-4" />
            @endif
        </h3>

        <p class="mt-1 leading-7 text-gray-800">
            {!! $thread->excerpt() !!}
        </p>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <div class="flex gap-x-5">
            <span class="flex items-center gap-x-2">
                <livewire:likes :subject="$thread" type="thread" />
                <span>{{ count($thread->likes()) }}</span>
                <span class="sr-only">Likes</span>
            </span>

            <span class="flex items-center gap-x-2">
                <x-heroicon-o-chat-bubble-left-right class="h-6 w-6" />
                <span>{{ count($thread->replies()) }}</span>
                <span class="sr-only">Replies</span>
            </span>
        </div>

        @if ($thread->isSolved())
            <a
                href="{{ route('thread', $thread->slug()) }}#{{ $thread->solution_reply_id }}"
                class="flex items-center gap-x-2 font-medium text-lio-500"
            >
                <x-heroicon-o-check-badge class="h-6 w-6" />
                <span class="hover:underline">Solved</span>
            </a>
        @endif
    </div>
</div>
