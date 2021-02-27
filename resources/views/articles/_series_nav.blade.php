@if ($article->series && $article->isPublished())
    <div class="flex items-center mt-12">
        @if ($previous = $article->previousInSeries())
            <a href="{{ route('articles.show', $previous->slug()) }}" class="flex justify-start w-full items-center">
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-8 flex-shrink-0 mr-4">
                    <path d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
                {{ $previous->title() }}
            </a>
        @endif

        @if ($next = $article->nextInSeries())
            <a href="{{ route('articles.show', $next->slug()) }}" class="flex justify-end items-center w-full">
                {{ $next->title() }}
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-8 flex-shrink-0 ml-4">
                    <path d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </a>
        @endif
    </div>
@endif