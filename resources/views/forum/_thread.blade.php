<li class="bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg">
    <article aria-labelledby="question-title-81614">
        <div>
            <div class="flex space-x-3">
                <div class="flex-shrink-0">
                    <x-avatar :user="$thread->author()" class="h-10 w-10 rounded-full" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        <a href="{{ route('profile', $thread->author()->username()) }}" class="hover:underline">
                            {{ $thread->author()->name() }}
                        </a>
                    </p>
                    <p class="text-sm text-gray-500">
                        <a href="{{ route('profile', $thread->author()->username()) }}" class="hover:underline">
                            {{ $thread->created_at->format('F j Y \a\t h:i A') }}
                        </a>
                    </p>
                </div>

                @if ($thread->isSolved())
                    <div class="flex-shrink-0 self-center flex">
                        <a href="{{ route('thread', $thread->slug()) }}#{{ $thread->solution_reply_id }}">
                            <x-badges.primary-badge hasDot>
                                Solved
                            </x-badges.primary-badge>
                        </a>
                    </div>
                @endif
            </div>
            <a href="{{ route('thread', $thread->slug()) }}">
                <h2 class="mt-4 text-base font-medium text-gray-900">
                    {{ $thread->subject() }}
                </h2>
            </a>
        </div>
        <div class="mt-2 text-sm text-gray-700 space-y-4">
            <p>
                <a href="{{ route('thread', $thread->slug()) }}">
                    {{ $thread->excerpt() }}
                </a>
            </p>
        </div>
        <div class="mt-6 flex justify-between space-x-8">
            <div class="flex space-x-6">
                <span class="inline-flex items-center text-sm">
                    <div class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <x-heroicon-s-thumb-up class="h-5 w-5" />
                        <span class="font-medium text-gray-900">{{ $thread->likesCount() }}</span>
                        <span class="sr-only">likes</span>
                    </div>
                </span>
                <span class="inline-flex items-center text-sm">
                    <div class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <x-heroicon-s-chat-alt class="h-5 w-5" />
                        <span class="font-medium text-gray-900">{{ $thread->repliesCount() }}</span>
                        <span class="sr-only">replies</span>
                    </div>
                </span>
            </div>

            @if ($thread->hasTags())
                <div class="flex text-sm">
                    @foreach ($thread->tags() as $tag)
                        <x-badges.badge class="ml-2">
                            {{ $tag->name() }}
                        </x-badges.badge>
                    @endforeach
                </div>
            @endif
        </div>
    </article>
</li>