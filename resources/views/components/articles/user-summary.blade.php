@props(['article'])

<div class="h-full rounded-lg bg-white shadow-lg">
    <div class="flex h-full flex-col gap-x-8">
        <a href="{{ route('articles.show', $article->slug()) }}" class="block">
            <div class="{{ $article->hasHeroImage() ? 'bg-cover' : '' }} h-32 w-full rounded-t-lg bg-gray-800 bg-center lg:h-40"
                style="background-image: url({{ $article->heroImage() }});">
            </div>
        </a>

        <div class="flex h-full flex-col gap-y-3 p-4">
            <div>
                <div class="flex flex-wrap items-center space-x-1 text-sm">
                    <div class="flex items-center">
                        <x-avatar :user="$article->author()" class="mr-2 h-6 w-6 rounded-full" unlinked />

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
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $article->title() }}
                    </h3>
                </a>

                <p class="mt-1 leading-7 text-gray-800">
                    {!! $article->excerpt() !!}
                </p>
            </div>

            <div class="flex h-full flex-col justify-end gap-y-3">
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
                    <span class="text-sm text-gray-500">
                        {{ $article->readTime() }} min read
                    </span>

                    <span class="flex items-center gap-x-2">
                        <livewire:likes :subject="$article" type="article" />
                        <span>{{ count($article->likes()) }}</span>
                        <span class="sr-only">Likes</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
