@props(['thread', 'reply'])

@if ($reply->trashed())
    <div class="bg-gray-50">
        <div>
@else
    <div class="bg-white shadow rounded @if (! $reply->trashed() && $thread->isSolutionReply($reply)) border-2 border-lio-400 @endif" id="{{ $reply->id() }}" x-data="{ edit: false }">
        <div class="border-b">
@endif
        <div class="flex flex-row justify-between items-center px-6 py-2">
            <div class="flex flex-wrap items-center space-x-1 text-sm">
                @if ($reply->trashed())
                    <div>
                        <div class="bg-white border border-gray-200 rounded-full h-8 w-8 -ml-2 lg:ml-6 mr-2 flex justify-center items-center">
                            @svg('heroicon-s-x-mark', 'h-4 w-4 text-gray-700')
                        </div>
                    </div>
                @endif

                <div class="inline-block">
                    <div class="flex items-center">
                        <x-avatar :user="$reply->trashed() ? $reply->remover() : $reply->author()" class="w-6 h-6 rounded-full mr-2" />

                        <a href="{{ route('profile', ($reply->trashed() ? $reply->remover() : $reply->author())->username()) }}" class="hover:underline">
                            <span class="text-gray-900 font-semibold">{{ ($reply->trashed() ? $reply->remover() : $reply->author())->username() }}</span>
                        </a>
                    </div>
                </div>

                @if ($reply->trashed())
                    <span class="pl-8 sm:pl-0">
                        deleted a reply from

                        <a href="{{ route('profile', $reply->author()->username()) }}" class="hover:underline">
                            <span class="text-gray-900 font-semibold">{{ $reply->author()->username() }}</span>
                        </a>
                    </span>
                @else
                    <span class="text-gray-700">replied</span>
                @endif

                <a
                    href="#{{ $reply->id() }}"
                    class="pl-8 sm:pl-0 text-gray-700 hover:text-lio-500 hover:underline"
                >
                    {{ ($reply->trashed() ? $reply->deletedAt() : $reply->createdAt())->diffForHumans() }}
                </a>
            </div>

            @unless ($reply->trashed())
                <x-threads.reply-menu :thread="$thread" :reply="$reply" />
            @endunless
        </div>
    </div>

    @unless ($reply->trashed())
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
    @endunless
</div>
