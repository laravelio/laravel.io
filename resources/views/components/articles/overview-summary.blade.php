@props([
    'article',
])

<div class="h-full rounded-lg shadow-lg bg-white lg:p-5">
    <div class="flex flex-col gap-x-8 lg:flex-row">
        <a href="{{ route('articles.show', $article->slug()) }}" class="block">
            <div
                class="w-full h-32 rounded-t-lg bg-center bg-cover bg-gray-900 lg:w-48 lg:h-full lg:rounded-lg"
                style="background-image: url({{ $article->heroImage() }});"
            >
            </div>
        </a>

        <div class="flex flex-col gap-y-3 p-4 lg:p-0 lg:gap-y-3.5">
            <div>
                <div class="flex flex-col gap-y-2 lg:flex-row lg:items-center">
                    <div class="flex">
                        <x-avatar :user="$article->author()" class="w-6 h-6 rounded-full mr-3" />

                        <a href="{{ route('profile', $article->author()->username()) }}" class="hover:underline">
                            <span class="text-gray-900 mr-5">{{ $article->author()->username() }}</span>
                        </a>
                    </div>

                    <span class="font-mono text-gray-700 mt-1 lg:mt-0">
                        {{ $article->createdAt()->format('j M, Y') }}
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

            <div class="flex flex-col gap-y-3 lg:flex-row lg:items-center lg:justify-between lg:flex-row-reverse">
                <div>
                    @if (count($tags = $article->tags()))
                        <div class="flex flex-wrap gap-2 lg:gap-x-4">
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
                        <x-heroicon-o-thumb-up class="w-6 h-6" />
                        <span>{{ count($article->likes()) }}</span>
                        <span class="sr-only">Likes</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
