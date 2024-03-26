@props([
    'article',
    'isFeatured' => false,
])

<div class="flex h-full flex-1 grow flex-col place-content-between">
    <div class="break-words">
        @if ($isFeatured)
            <a href="{{ route('articles.show', $article->slug()) }}">
                <div
                    class="{{ $article->hasHeroImage() ? 'bg-cover' : '' }} mb-6 h-72 w-full rounded-lg bg-gray-800 bg-center"
                    style="background-image: url({{ $article->heroImage() }})"
                ></div>
            </a>
        @endif

        <span class="mb-2 block font-mono leading-6 text-gray-700">
            {{ $article->submittedAt()->format('F jS Y') }}
        </span>

        @if ($isFeatured)
            <h3 class="mb-2 text-3xl font-bold leading-10 text-gray-900">
                <a href="{{ route('articles.show', $article->slug()) }}" class="hover:underline">
                    {{ $article->title() }}
                </a>
            </h3>
        @else
            <h4 class="mb-3 text-2xl font-bold leading-8 text-gray-900">
                <a href="{{ route('articles.show', $article->slug()) }}" class="hover:underline">
                    {{ $article->title() }}
                </a>
            </h4>
        @endif

        <p class="mb-3 leading-7 text-gray-800">
            {{ $article->excerpt() }}
        </p>
    </div>

    <x-buttons.arrow-button href="{{ route('articles.show', $article->slug()) }}" class="items-end py-2">Read article</x-buttons.arrow-button>
</div>
