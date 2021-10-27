@props([
    'thread',
])

<div class="h-full rounded shadow-lg p-5">
    <div class="h-full flex flex-col place-content-between">
        <div class="break-words">
            <div class="flex items-center justify-between mb-2.5">
                <div class="flex items-center">
                    <x-avatar :user="$thread->author()" class="w-8 h-8 rounded-full mr-2" />

                    <a href="{{ route('profile', $thread->author()->username()) }}">
                        <span class="font-heading text-sm text-black">{{ $thread->author()->username() }}</span>
                    </a>
                </div>

                <div>
                    <span class="text-sm text-gray-600">
                        {{ $thread->createdAt()->diffForHumans() }}
                    </span>
                </div>
            </div>

            <h3 class="text-gray-900 text-2xl mb-2 leading-8">
                <a href="{{ route('thread', $thread->slug()) }}">
                    {{ $thread->subject() }}
                </a>
            </h3>

            <p class="text-gray-800 text-base leading-7 mb-3">
                {!! $thread->excerpt() !!}
            </p>
        </div>

        <x-buttons.arrow-button href="{{ route('thread', $thread->slug()) }}" class="items-end">
            Open thread
        </x-buttons.arrow-button>
    </div>
</div>
