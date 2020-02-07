<div class="container mx-auto flex flex-wrap mb-2">
    <div class="w-full">
        @forelse ($user->latestReplies() as $reply)
            <div class="thread-card">
                <div class="flex justify-between">
                    <a href="{{ route('thread', $reply->replyAble()->slug()) }}">
                        <h4 class="text-xl font-bold text-gray-900">
                            {{ $reply->replyAble()->subject() }}
                        </h4>
                        <p class="text-gray-600" v-pre>{!! $reply->excerpt() !!}</p>
                    </a>
                    <div>
                        @if ($reply->replyAble()->isSolutionReply($reply))
                            <span class="label label-primary text-center mt-4 md:mt-0 mr-2">
                                <i class="fa fa-check mr-2"></i>
                                Solution
                            </span>
                        @endif
                        <span class="text-base font-normal">
                            <i class="fa fa-thumbs-up text-gray-500 mr-1"></i>
                            {{ $reply->likes_count }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-lg">{{ $user->name() }} has not posted any threads yet.</p>
        @endforelse
    </div>
</div>
