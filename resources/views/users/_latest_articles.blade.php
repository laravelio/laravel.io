<div class="container mx-auto flex flex-wrap mb-2">
    <div class="w-full">
        @forelse ($user->latestArticles(5) as $article)
            <div class="thread-card">
                <div class="flex justify-between">
                    <a href="{{ route('articles.show', $article->slug()) }}">
                        <div class="flex items-center">
                            <h4 class="text-xl font-bold text-gray-900">
                                {{ $article->title() }}
                            </h4>

                            @if ($article->isNotPublished())
                                <span class="label inline-flex ml-4">
                                    @if ($article->isAwaitingApproval()))
                                        Awaiting Approval
                                    @else
                                        Draft
                                    @endif
                                </span>
                            @endif
                        </div>

                        <p class="text-gray-600">
                            {!! $article->excerpt() !!}
                        </p>
                    </a>

                    <div class="flex items-center">
                        <span class="text-2xl mr-2">👏</span>
                        <span class="text-base font-normal">
                            {{ $article->likesCount() }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col justify-between md:flex-row md:items-center text-sm pt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex mb-4 md:mb-0">
                            <div class="text-gray-700">
                                @if ($article->isPublished())
                                    Published {{ $article->submittedAt()->diffForHumans() }}
                                @else
                                    @if($article->isAwaitingApproval())
                                        Awaiting Approval
                                    @else
                                        Drafted {{ $article->updatedAt()->diffForHumans() }}
                                    @endif
                                @endif
                            </div>
                        </div>

                        @if (count($article->tags()))
                            <div class="ml-6">
                                @foreach ($article->tags() as $tag)
                                    <a href="{{ route('forum.tag', $tag->slug()) }}">
                                        <span class="bg-gray-300 text-gray-700 rounded px-2 py-1">{{ $tag->name() }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-base">
                {{ $user->name() }} has not posted any articles yet
            </p>
        @endforelse
    </div>
</div>
