@props(['thread'])

<div class="thread bg-white shadow rounded">
    <div class="border-b">
        <div class="px-6 pt-4 pb-0 lg:py-4">
        <div class="flex flex-row justify-between items-start lg:items-center">
            <div>
                <div class="flex flex-col lg:flex-row lg:items-center">
                    <div>
                        <a href="{{ route('profile', $thread->author()->username()) }}" class="flex items-center hover:underline">
                            <x-avatar :user="$thread->author()" class="w-6 h-6 rounded-full mr-3" />
                            <span class="text-gray-900 mr-5">{{ $thread->author()->username() }}</span>
                        </a>
                    </div>

                    <span class="font-mono text-gray-700 mt-1 lg:mt-0">
                        {{ $thread->createdAt()->format('j M, Y \a\t h:i') }}
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
        x-init="function () { highlightCode($el); }"
        x-html="{{ json_encode(replace_links(md_to_html($thread->body()))) }}"
    >
    </div>

    <div class="px-6 pb-6">
        <livewire:like-thread :thread="$thread"/>
    </div>
</div>
