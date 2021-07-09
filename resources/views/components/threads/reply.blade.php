@props(['thread', 'reply'])

<div>
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center border-b">
        <div>
            <div class="flex flex-col lg:flex-row lg:items-center">
                <div class="flex">
                    <x-avatar :user="$reply->author()" class="w-6 h-6 rounded-full mr-3" />

                    <a href="{{ route('profile', $reply->author()->username()) }}" class="hover:underline">
                        <span class="text-gray-900 mr-5">{{ $reply->author()->name() }}</span>
                    </a>
                </div>

                <span class="font-mono text-gray-700 mt-1 lg:mt-0">
                    {{ $reply->createdAt()->format('j M, Y \a\t h:i') }}
                </span>
            </div>
        </div>

        @if ($thread->isSolutionReply($reply))
            <span class="flex items-center gap-x-2 font-medium text-lio-500">
                <x-heroicon-o-badge-check class="w-6 h-6" />
                <span class="hover:underline">Solution</span>
            </a>
        @endif
    </div>

    <div
        class="forum-content"
        x-data="{}"
        x-init="function () { highlightCode($el); }"
        x-html="{{ json_encode(replace_links(md_to_html($reply->body()))) }}"
    >
    </div>

    <div>
        <span class="flex items-center gap-x-2">
            <x-heroicon-o-thumb-up class="w-6 h-6" />
            <span>{{ count($reply->likes()) }}</span>
            <span class="sr-only">Likes</span>
        </span>
    </div>
</div>