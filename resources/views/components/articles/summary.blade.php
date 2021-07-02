@props([
    'image' => null,
    'article',
    'isFeatured' => false,
])

<div class="mb-8 md:mb-0">
    @if ($image)
        <div class="w-full h-72 mb-6 rounded-lg bg-center bg-cover" style="background-image: url({{ $image }});"></div>
    @endif

    <span class="font-mono text-gray-700 leading-6 mb-2 block">
        {{ $article->submittedAt()->format('F jS Y') }}
    </span>

    @if ($isFeatured)
        <h3 class="text-gray-900 text-3xl font-bold leading-10 mb-2">
            {{ $article->title() }}
        </h3>
    @else
        <h4 class="text-gray-900 text-2xl font-bold leading-8 mb-3">
            {{ $article->title() }}
        </h4>
    @endif

    <p class="text-gray-800 leading-7 mb-3">
        {{ $article->excerpt() }}
    </p>

    <x-buttons.arrow-button href="{{ route('articles.show', $article->slug()) }}">
        Read article
    </x-buttons.arrow-button>
</div>

