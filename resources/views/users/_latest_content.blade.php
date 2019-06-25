<div class="container mx-auto px-4 flex flex-wrap mb-2">
    <div class="w-full md:w-1/2">
        <div class="md:mr-2">
            <h3 class="text-gray-900 mb-2 text-xl">Latest Threads</h3>

            @forelse ($user->latestThreads() as $thread)
            <div class="bg-white p-4 border rounded mb-2">
                <a href="{{ route('thread', $thread->slug()) }}">
                    <h4 class="flex justify-between text-xl font-bold text-gray-900">
                        {{ $thread->subject() }}
                    </h4>
                    <p class="text-gray-600">{{ $thread->excerpt() }}</p>
                </a>
            </div>
            @empty
                <p class="text-gray-600 text-lg">{{ $user->name() }} has not posted any threads yet.</p>
            @endforelse
        </div>
    </div>

    <div class="w-full md:w-1/2">
        <div class="md:ml-2">
            <h3 class="text-gray-900 mb-2 text-xl">Latest Replies</h3>

            @forelse ($user->latestReplies() as $reply)
                <div class="bg-white p-4 border rounded mb-2">
                    <a href="{{ route_to_reply_able($reply->replyAble()) }}">
                        <h4 class="flex justify-between text-xl font-bold text-gray-900">
                            {{ $reply->replyAble()->subject() }}
                        </h4>
                        <p class="text-gray-600">{{ $reply->excerpt() }}</p>
                    </a>
                </div>
            @empty
                <p class="text-gray-600 text-lg">{{ $user->name() }} has not posted any replies yet.</p>
            @endforelse
        </div>
    </div>
</div>
