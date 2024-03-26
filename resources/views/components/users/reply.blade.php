@props(['thread', 'reply'])

<div class="h-full rounded bg-white p-5 shadow-lg">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
            <div class="flex flex-wrap items-center space-x-1 text-sm">
                <div class="flex items-center">
                    <x-avatar :user="$reply->author()" class="mr-2 h-6 w-6 rounded-full" />

                    <a href="{{ route('profile', $reply->author()->username()) }}" class="hover:underline">
                        <span class="font-semibold text-gray-900">{{ $reply->author()->username() }}</span>
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
            <h3 class="text-xl font-semibold text-gray-900">
                {{ $thread->subject() }}
            </h3>
        </a>

        <p class="mt-1 leading-7 text-gray-800">
            {!! $reply->excerpt() !!}
        </p>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <div class="flex gap-x-5">
            <span class="flex items-center gap-x-2">
                <livewire:likes :subject="$reply" type="reply" />
                <span>{{ count($reply->likes()) }}</span>
                <span class="sr-only">Likes</span>
            </span>
        </div>

        @if ($thread->isSolutionReply($reply))
            <span class="flex items-center gap-x-2 font-medium text-lio-500">
                <x-heroicon-o-check-badge class="h-6 w-6" />
                <span class="hover:underline">Solved</span>
            </span>
        @endif
    </div>
</div>
