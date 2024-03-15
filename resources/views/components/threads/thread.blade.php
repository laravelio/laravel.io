@props(['thread'])

<div class="thread rounded bg-white shadow">
    <div class="border-b">
        <div class="px-4 pb-1 pt-4 lg:px-6 lg:py-2">
            <div class="flex flex-row items-start justify-between lg:items-center">
                <div>
                    <div class="flex flex-wrap items-center space-x-1 text-sm">
                        <div class="flex items-center">
                            <x-avatar :user="$thread->author()" class="mr-2 h-6 w-6 rounded-full" />

                            <a href="{{ route('profile', $thread->author()->username()) }}" class="hover:underline">
                                <span class="font-semibold text-gray-900">{{ $thread->author()->username() }}</span>
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
                        <div class="mt-2 hidden flex-wrap gap-2 lg:mt-0 lg:flex lg:flex-nowrap lg:gap-x-4">
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
                <div class="my-2 flex flex-wrap gap-2 lg:hidden">
                    @foreach ($tags as $tag)
                        <x-tag>
                            {{ $tag->name() }}
                        </x-tag>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="prose-lio prose max-w-none break-words p-6" x-data="{}" x-init="$nextTick(function() { highlightCode($el); })"
        x-html="{{ json_encode(replace_links(md_to_html($thread->body()))) }}">
    </div>

    @if ($thread->isUpdated())
        <div class="p-6 text-sm text-gray-900">
            Last updated

            @if ($updatedBy = $thread->updatedBy())
                by <a href="{{ route('profile', $updatedBy->username()) }}"
                    class="border-b-2 border-lio-100 pb-0.5 text-lio-500 hover:text-lio-600">
                    {{ '@' . $thread->updatedBy()->username() }}
                </a>
            @endif

            {{ $thread->updated_at->diffForHumans() }}.
        </div>
    @endif

    <div class="px-6 pb-6">
        <livewire:like-thread :thread="$thread" />
    </div>
</div>
