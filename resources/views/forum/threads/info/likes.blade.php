<div class="thread-info-likes">
    @if (Auth::guest())
        @if ($likeable->likes_count)
            <div class="text-gray-600 px-4 py-2 border-r inline-block">
                <span class="text-2xl mr-1">👍</span>
                {{ $likeable->likes_count }}
            </div>
        @endif
    @else   
        @if (! $likeable->isLikedBy(auth()->user()))
            <form action="{{ route(...$like) }}" method="post">
                @csrf
                @method('put')

                <button type="submit" class="text-green-dark px-4 py-2 border-r">
                    <span class="text-2xl mr-1">👍</span>
                    {{ $likeable->likes_count }}
                </button>
            </form>
        @else
            <form action="{{ route(...$unlike) }}" method="post">
                @csrf
                @method('delete')

                <button type="submit" class="text-green-dark px-4 py-2 border-r">
                    <span class="text-2xl mr-1">👍</span>
                    {{ $likeable->likes_count }}
                </button>
            </form>
        @endif
    @endif
</div>
