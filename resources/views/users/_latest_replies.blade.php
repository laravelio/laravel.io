<div class="container mx-auto flex flex-wrap mb-2">
    <div class="w-full">
        @forelse ($user->latestReplies() as $reply)
            <div class="thread-card">
                <div class="flex justify-between">
                    <a href="{{ route('thread', $reply->replyAble()->slug()) }}">
                        <h4 class="text-xl font-bold text-gray-900">
                            {{ $reply->replyAble()->subject() }}
                        </h4>

                        <p class="text-gray-600">
                            {!! $reply->excerpt() !!}
                        </p>
                    </a>

                    <div>
                        <span class="text-base font-normal">
                            <i class="fa fa-thumbs-up text-gray-500 mr-1"></i>
                            {{ $reply->likes_count }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col justify-between md:flex-row md:items-center text-sm pt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex mb-4 md:mb-0">
                            <div class="mr-6 text-gray-700">
                                Posted {{ $reply->createdAt()->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    @if ($reply->replyAble()->isSolutionReply($reply))
                        <span class="label label-primary text-center mt-4 md:mt-0">
                            <i class="fa fa-check mr-2"></i>
                            Solution
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-base">
                {{ $user->name() }} has not posted any replies yet
            </p>
        @endforelse
    </div>
</div>
