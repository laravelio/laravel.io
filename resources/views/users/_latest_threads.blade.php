<div class="container mx-auto flex flex-wrap mb-2">
    <div class="w-full">
        @forelse ($user->latestThreads() as $thread)
            <div class="thread-card">
                <div class="flex justify-between">
                    <a href="{{ route('thread', $thread->slug()) }}">
                        <h4 class="text-xl font-bold text-gray-900">
                            {{ $thread->subject() }}
                        </h4>

                        <p class="text-gray-600">
                            {!! $thread->excerpt() !!}
                        </p>
                    </a>

                    <div>
                        <span class="text-base font-normal mr-2">
                            <i class="fa fa-comment text-gray-500 mr-1"></i>
                            {{ count($thread->replies()) }}
                        </span>

                        <span class="text-base font-normal">
                            <i class="fa fa-thumbs-up text-gray-500 mr-1"></i>
                            {{ $thread->likes_count }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col justify-between md:flex-row md:items-center text-sm pt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex mb-4 md:mb-0">
                            @if (count($thread->replies()))
                                @include('forum.threads.info.avatar', ['user' => $thread->replies()->last()->author()])
                            @else
                                @include('forum.threads.info.avatar', ['user' => $thread->author()])
                            @endif

                            <div class="mr-6 text-gray-700">
                                @if (count($thread->replies()))
                                    @php($lastReply = $thread->replies()->last())
                                    <a href="{{ route('profile', $lastReply->author()->username()) }}"
                                       class="text-green-darker">
                                        {{ $lastReply->author()->isLoggedInUser() ? 'You' : $lastReply->author()->name() }}
                                    </a> replied {{ $lastReply->createdAt()->diffForHumans() }}
                                @else
                                    <a href="{{ route('profile', $thread->author()->username()) }}"
                                       class="text-green-darker">
                                        {{ $thread->author()->isLoggedInUser() ? 'You' : $thread->author()->name() }}
                                    </a> posted {{ $thread->createdAt()->diffForHumans() }}
                                @endif
                            </div>
                        </div>

                        @include('forum.threads.info.tags')
                    </div>

                    @if ($thread->isSolved())
                        <a class="label label-primary text-center mt-4 md:mt-0"
                           href="{{ route('thread', $thread->slug()) }}#{{ $thread->solutionReplyRelation->id }}">
                            <i class="fa fa-check mr-2"></i>
                            View solution
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-lg">
                {{ $user->name() }} has not posted any threads yet.
            </p>
        @endforelse
    </div>
</div>
