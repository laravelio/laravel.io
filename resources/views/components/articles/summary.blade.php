@props([
    'article',
    'isFeatured' => false,
])

<div class="h-full flex flex-1 flex-col grow place-content-between">
    <div class="break-words">
        @if ($isFeatured)
            <a href="{{ route('articles.show', $article->slug()) }}">
                <img class="w-full h-72 mb-6 rounded-lg bg-center bg-gray-800 object-cover"
                     src="{{ $article->heroImage() }}"
                     alt="Article Hero Image"
                     onerror="
                        this.onerror=null;
                        this.src='{{ asset('images/default-background.svg') }}'"
                >
            </a>
        @endif

        <span class="font-mono text-gray-700 leading-6 mb-2 block">
            {{ $article->submittedAt()->format('F jS Y') }}

            @if ($article->isSponsored())
                <x-tag>Sponsored</x-tag>
            @endif
        </span>

        @if ($isFeatured)
            <h3 class="text-gray-900 text-3xl font-bold leading-10 mb-2">
                <a href="{{ route('articles.show', $article->slug()) }}" class="hover:underline">
                    {{ $article->title() }}
                </a>
            </h3>
        @else
            <h4 class="text-gray-900 text-2xl font-bold leading-8 mb-3">
                <a href="{{ route('articles.show', $article->slug()) }}" class="hover:underline">
                    {{ $article->title() }}
                </a>
            </h4>
        @endif

        <p class="text-gray-800 leading-7 mb-3">
            {{ $article->excerpt() }}
        </p>
    </div>

    <x-buttons.arrow-button href="{{ route('articles.show', $article->slug()) }}" class="items-end py-2">
        Read article
    </x-buttons.arrow-button>
</div>
