@props(['thread', 'reply'])

<div class="h-full rounded shadow-lg p-5 bg-white">
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
        <div>
            <div class="flex flex-wrap items-center space-x-1 text-sm">
                <div class="flex items-center">
                    <x-avatar :user="$reply->author()" class="w-6 h-6 rounded-full mr-2" />

                    <a href="{{ route('profile', $reply->author()->username()) }}" class="hover:underline">
                        <span class="text-gray-900 font-semibold">{{ $reply->author()->username() }}</span>
                    </a>
                </div>

                <span class="text-gray-700">replied</span>

                <span class="text-gray-700">
                    {{ $reply->createdAt()->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>

    <div class="mt-3 break-words">
        <a href="{{ route('thread', $thread->slug()) }}" class="hover:underline">
            <h3 class="text-xl text-gray-900 font-semibold">
                {{ $thread->subject() }}
            </h3>
        </a>

        <p class="text-gray-800 leading-7 mt-1">
            {!! $reply->excerpt() !!}
        </p>
    </div>

    <div class="flex justify-between items-center mt-4">
        <div class="flex gap-x-5">
            <span class="flex items-center gap-x-2">
                <x-heroicon-o-hand-thumb-up class="w-6 h-6" />
                <span>{{ count($reply->likes()) }}</span>
                <span class="sr-only">Likes</span>
            </span>
        </div>

        @if ($thread->isSolutionReply($reply))
            <span class="flex items-center gap-x-2 font-medium text-lio-500">
                <x-heroicon-o-check-badge class="w-6 h-6" />
                <span class="hover:underline">Solved</span>
            </span>
        @endif
    </div>
</div>
