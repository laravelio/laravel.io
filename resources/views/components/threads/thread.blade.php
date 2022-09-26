@props(['thread'])

<div class="thread bg-white shadow rounded">
    <div class="border-b">
        <div class="px-4 pt-4 pb-1 lg:px-6 lg:py-2">
            <div class="flex flex-row justify-between items-start lg:items-center">
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

                <div class="flex items-center gap-x-2">
                    @if (count($tags = $thread->tags()))
                        <div class="hidden flex-wrap gap-2 mt-2 lg:mt-0 lg:gap-x-4 lg:flex lg:flex-nowrap">
                            @foreach ($tags as $tag)
                                <a href="{{ route('forum.tag', $tag->slug()) }}">
                                    <x-tag>
                                        {{ $tag->name() }}
                                    </x-tag>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <x-threads.thread-menu :thread="$thread" />
                </div>
            </div>

            @if (count($tags = $thread->tags()))
                <div class="flex flex-wrap gap-2 my-2 lg:hidden">
                    @foreach ($tags as $tag)
                        <x-tag>
                            {{ $tag->name() }}
                        </x-tag>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div
        class="prose prose-lio max-w-none p-6 break-words"
        x-data="{}"
        x-init="$nextTick(function () { highlightCode($el); })"
        x-html="{{ json_encode(replace_links(md_to_html($thread->body()))) }}"
    >
    </div>

    @if ($thread->isUpdated())
        <div class="text-sm text-gray-900 p-6">
            Last updated

            @if ($updatedBy = $thread->updatedBy())
                by <a href="{{ route('profile', $updatedBy->username()) }}" class="text-lio-500 border-b-2 pb-0.5 border-lio-100 hover:text-lio-600">
                    {{ '@'.$thread->updatedBy()->username() }}
                </a>
            @endif

            {{ $thread->updated_at->diffForHumans() }}.
        </div>
    @endif

    <div class="px-6 pb-6">
        <livewire:like-thread :thread="$thread"/>
    </div>
</div>
