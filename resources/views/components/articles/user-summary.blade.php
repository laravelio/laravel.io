@props([
    'article',
])

<div class="h-full rounded-lg shadow-lg bg-white">
    <div class="flex flex-col h-full gap-x-8">
        <a href="{{ route('articles.show', $article->slug()) }}" class="block">
            <div
                class="w-full h-32 rounded-t-lg bg-center {{ $article->hasHeroImage() ? 'bg-cover' : '' }} bg-gray-800 lg:h-40"
                style="background-image: url({{ $article->heroImage() }});"
            >
            </div>
        </a>

        <div class="flex flex-col h-full gap-y-3 p-4">
            <div>
                <div class="flex flex-wrap items-center space-x-1 text-sm">
                    <div class="flex items-center">
                        <x-avatar :user="$article->author()" class="w-6 h-6 rounded-full mr-2" unlinked />

                        <span class="text-gray-900">{{ $article->author()->username() }}</span>
                    </div>

                    <span class="text-gray-700">published on</span>

                    <span class="text-gray-700">
                        {{ $article->approvedAt()->format('j M, Y') }}
                    </span>
                </div>
            </div>

            <div class="break-words">
                <a href="{{ route('articles.show', $article->slug()) }}" class="hover:underline">
                    <h3 class="text-xl text-gray-900 font-semibold">
                        {{ $article->title() }}
                    </h3>
                </a>

                <p class="text-gray-800 leading-7 mt-1">
                    {!! $article->excerpt() !!}
                </p>
            </div>

            <div class="flex flex-col h-full justify-end gap-y-3">
                <div>
                    @if (count($tags = $article->tags()))
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                                <x-tag>
                                    {{ $tag->name() }}
                                </x-tag>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-x-5">
                    <span class="text-gray-500 text-sm">
                        {{ $article->readTime() }} min read
                    </span>

                    <span class="flex items-center gap-x-2">
                        <x-heroicon-o-hand-thumb-up class="w-6 h-6" />
                        <span>{{ count($article->likes()) }}</span>
                        <span class="sr-only">Likes</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
