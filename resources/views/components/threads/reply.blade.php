@props(['thread', 'reply'])

<div class="bg-white shadow rounded @if ($thread->isSolutionReply($reply)) border-2 border-lio-400 @endif" id="{{ $reply->id() }}">
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

                    <span class="font-mono text-gray-700 mt-1 lg:mt-0">
                        {{ $reply->createdAt()->diffForHumans() }}
                    </span>
                </div>
            </div>

            <x-threads.reply-menu :thread="$thread" :reply="$reply" />
        </div>
    </div>

    <div
        class="prose prose-lio max-w-none p-6 break-words"
        x-data="{}"
        x-init="$nextTick(function () { highlightCode($el); })"
        x-html="{{ json_encode(replace_links(md_to_html($reply->body()))) }}"
    >
    </div>

    @if ($reply->isUpdated())
        <div class="text-sm text-gray-900 p-6">
            Last updated

            @if ($updatedBy = $reply->updatedBy())
                by <a href="{{ route('profile', $updatedBy->username()) }}" class="text-lio-500 border-b-2 pb-0.5 border-lio-100 hover:text-lio-600">
                    {{ '@'.$reply->updatedBy()->username() }}
                </a>
            @endif

            {{ $reply->updated_at->diffForHumans() }}.
        </div>
    @endif

    <div class="flex justify-between">
        <div class="px-6 pb-6">
            <livewire:like-reply :reply="$reply"/>
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
