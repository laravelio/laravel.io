@props(['thread'])

<div class="thread bg-white shadow rounded">
    <div class="border-b">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center px-6 py-4">
            <div>
                <div class="flex flex-col lg:flex-row lg:items-center">
                    <div class="flex">
                        <x-avatar :user="$thread->author()" class="w-6 h-6 rounded-full mr-3" />

                        <a href="{{ route('profile', $thread->author()->username()) }}" class="hover:underline">
                            <span class="text-gray-900 mr-5">{{ $thread->author()->name() }}</span>
                        </a>
                    </div>

                    <span class="font-mono text-gray-700 mt-1 lg:mt-0">
                        {{ $thread->createdAt()->format('j M, Y \a\t h:i') }}
                    </span>
                </div>
            </div>

            @if (count($tags = $thread->tags()))
                <div class="flex gap-x-4 mt-2 lg:mt-0">
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