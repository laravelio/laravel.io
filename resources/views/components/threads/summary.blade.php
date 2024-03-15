@props(['thread'])

<div class="h-full rounded p-5 shadow-lg">
    <div class="flex h-full flex-col place-content-between">
        <div class="break-words">
            <div class="mb-2.5 flex items-center justify-between">
                <div class="flex items-center">
                    <x-avatar :user="$thread->author()" class="mr-2 h-8 w-8 rounded-full" />

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

            <h3 class="mb-2 text-2xl leading-8 text-gray-900">
                <a href="{{ route('thread', $thread->slug()) }}">
                    {{ $thread->subject() }}
                </a>
            </h3>

            <p class="mb-3 text-base leading-7 text-gray-800">
                {!! $thread->excerpt() !!}
            </p>
        </div>

        <x-buttons.arrow-button href="{{ route('thread', $thread->slug()) }}" class="items-end">
            Open thread
        </x-buttons.arrow-button>
    </div>
</div>
