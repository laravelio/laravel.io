@props(['thread', 'reply'])

<div class="bg-white shadow rounded @if ($thread->isSolutionReply($reply)) border-2 border-lio-400 @endif" id="{{ $reply->id() }}" x-data="{ edit: false }">
    <div class="border-b">
        <div class="flex flex-row justify-between items-center px-6 py-2.5">
            <div>
                <div class="flex flex-col lg:flex-row lg:items-center">
                    <div class="flex items-center">
                        <x-avatar :user="$reply->author()" class="w-6 h-6 rounded-full mr-3" />

                        <a href="{{ route('profile', $reply->author()->username()) }}" class="hover:underline">
                            <span class="text-gray-900 mr-5">{{ $reply->author()->username() }}</span>
                        </a>
                    </div>

                    <a
                        href="#{{ $reply->id() }}"
                        class="font-mono text-gray-700 hover:text-lio-500 hover:underline mt-1 lg:mt-0"
                    >
                        {{ $reply->createdAt()->diffForHumans() }}
                    </a>
                </div>
            </div>

            <x-threads.reply-menu :thread="$thread" :reply="$reply" />
        </div>
    </div>

    <livewire:edit-reply :reply="$reply" />

    <div class="flex justify-between" x-show="!edit">
        <div class="px-6 pb-6">
            <livewire:like-reply :reply="$reply" />
        </div>

        @if ($thread->isSolutionReply($reply) && $resolvedBy = $thread->resolvedBy())
            <div class="px-6 pb-6 text-lio-500">
                Solution selected by
                <a
                    href="{{ route('profile', $resolvedBy->username()) }}"
                    class="font-bold text-lio-600 hover:text-lio-800"
                >
                    {{ '@'.$resolvedBy->username() }}
                </a>
            </div>
        @endif
    </div>
</div>
