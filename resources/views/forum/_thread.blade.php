<li class="px-4 lg:px-0">
    <article class="bg-white p-4 shadow rounded-lg" aria-labelledby="{{ $thread->slug() }}">
        <div class="md:flex md:justify-between">
            <a href="{{ route('thread', $thread->slug()) }}" class="hover:underline">
                <h2 class="text-xl font-medium text-gray-900">
                    {{ $thread->subject() }}
                </h2>
            </a>

            <div class="md:flex-shrink-0 md:self-center md:flex mt-2 md:mt-0">
                @if (count($tags = $thread->tags()))
                    <div class="flex text-sm space-x-2">
                        @foreach ($tags as $tag)
                            <x-tag>
                                {{ $tag->name() }}
                            </x-tag>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-2 text-sm text-gray-700 space-y-4">
            <p>
                <a href="{{ route('thread', $thread->slug()) }}" class="hover:underline">
                    {!! $thread->excerpt() !!}
                </a>
            </p>
        </div>

        <div class="mt-4 flex justify-between space-x-8">
            <div class="flex space-x-3">
                <div class="flex-shrink-0">
                    <x-avatar :user="$thread->author()" class="h-10 w-10 sm:h-5 sm:w-5 rounded-full" />
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm text-gray-900">
                        <a href="{{ route('profile', $thread->author()->username()) }}" class="font-medium hover:underline">
                            {{ $thread->author()->name() }}
                        </a>

                        &bull;

                        <span class="text-sm text-gray-500">
                            {{ $thread->created_at->format('F j, Y \a\t h:i A') }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="flex space-x-4">
                @if ($thread->isSolved())
                    <span class="inline-flex items-center text-sm">
                        <div class="inline-flex space-x-2">
                            <a
                                href="{{ route('thread', $thread->slug()) }}#{{ $thread->solution_reply_id }}"
                                class="rounded-full p-1 bg-lio-100 text-lio-500"
                                title="Resolved"
                            >
                                <x-heroicon-o-check class="h-5 w-5" />
                            </a>
                        </div>
                    </span>
                @endif

                <span class="inline-flex items-center text-sm">
                    <div class="inline-flex space-x-2 text-gray-400">
                        <x-heroicon-s-thumb-up class="h-5 w-5" />
                        <span class="font-medium text-gray-900">{{ count($thread->likes()) }}</span>
                        <span class="sr-only">Likes</span>
                    </div>
                </span>

                <span class="inline-flex items-center text-sm">
                    <div class="inline-flex space-x-2 text-gray-400">
                        <x-heroicon-s-chat-alt class="h-5 w-5" />
                        <span class="font-medium text-gray-900">{{ count($thread->replies()) }}</span>
                        <span class="sr-only">Replies</span>
                    </div>
                </span>
            </div>
        </div>
    </article>
</li>
