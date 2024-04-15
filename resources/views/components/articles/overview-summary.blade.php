@props([
    'article',
    'mode',
    'showViewCount' => false,
])

<div class="h-full rounded-lg bg-white shadow-lg lg:p-5">
    <div class="flex flex-col gap-x-8 lg:flex-row">
        <a href="{{ route('articles.show', $article->slug()) }}" class="block">
            <div
                class="{{ $article->hasHeroImage() ? 'bg-cover' : '' }} h-32 w-full rounded-t-lg bg-gray-800 bg-center lg:h-full lg:w-48 lg:rounded-lg"
                style="background-image: url({{ $article->heroImage() }})"
            ></div>
        </a>

        <div class="flex w-full flex-col gap-y-3 p-4 lg:gap-y-3.5 lg:p-0">
            <div>
                <div class="flex flex-col justify-between gap-y-2 lg:flex-row lg:items-center">
                    <div class="flex flex-wrap items-center space-x-1 text-sm">
                        <div class="flex items-center">
                            <x-avatar :user="$article->author()" class="mr-2 h-6 w-6 rounded-full" />

                            <a href="{{ route('profile', $article->author()->username()) }}" class="hover:underline">
                                <span class="font-semibold text-gray-900">{{ $article->author()->username() }}</span>
                            </a>
                        </div>

                        @if ($article->isApproved())
                            <span class="text-gray-700">published on</span>

                            <span class="text-gray-700">
                                {{ $article->approvedAt()->format('j M, Y') }}
                            </span>
                        @else
                            <span class="text-gray-700">authored on</span>

                            <span class="text-gray-700">
                                {{ $article->createdAt()->format('j M, Y') }}
                            </span>
                        @endif
                    </div>

                    @if (isset($mode) && $mode == 'edit')
                        <x-articles.article-menu :article="$article" />
                    @endif
                </div>

                @if (isset($mode) && $mode == 'edit')
                    <div class="flex text-sm leading-5 text-gray-500">
                        @if ($article->isPublished())
                            <time datetime="{{ $article->submittedAt()->format('Y-m-d') }}">
                                Published {{ $article->submittedAt()->format('j M, Y') }}
                            </time>
                        @else
                            @if ($article->isAwaitingApproval())
                                <span> Awaiting Approval </span>
                            @else
                                <time datetime="{{ $article->updatedAt()->format('Y-m-d') }}">
                                    Drafted {{ $article->updatedAt()->format('j M, Y') }}
                                </time>
                            @endif
                        @endif
                    </div>
                @endif
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

            <div class="flex flex-col gap-y-3 lg:flex-row-reverse lg:items-center lg:justify-between">
                <div>
                    @if (count($tags = $article->tags()))
                        <div class="flex flex-wrap gap-2 lg:gap-x-4">
                            @foreach ($tags as $tag)
                                <a href="{{ route('articles', ['tag' => $tag->slug()]) }}" class="hover:underline">
                                    <x-tag :tag="$tag">
                                        {{ $tag->name() }}
                                    </x-tag>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-x-5">
                    <span class="text-sm text-gray-500"> {{ $article->readTime() }} min read </span>

                    @if ($showViewCount)
                        <span class="text-sm text-gray-500"> {{ $article->viewCount() }} views </span>
                    @endif

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
