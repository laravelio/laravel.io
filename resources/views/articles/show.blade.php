@title($article->title())
@canonical($article->canonicalUrl())
@shareImage(route('articles.image', $article->slug()))

@extends('layouts.default')

@section('content')
    <article class="bg-white">
        @auth
            @if ($article->isDeclined() && (Auth::user()->isAdmin() || Auth::user()->isModerator()))
                <x-info-banner>
                    {{ __('The article has been declined and will only be shown to the user.') }}
                </x-info-banner>
            @elseif ($article->isPublished() && $article->isAuthoredBy(Auth::user()))
                <x-info-banner>
                    Your article is now published and cannot be edited anymore. If you want to perform any changes to the article, please email <a href="mailto:hello@laravel.io">hello@laravel.io</a>
                </x-info-banner>
            @endif
        @endauth

        <div class="container mx-auto">
            <div class="px-4 lg:px-0 lg:mx-48">
                <div
                    class="w-full bg-center bg-gray-800"
                    style="background-image: url('{{ asset('images/default-background.svg') }}')"
                >
                <div class="relative w-full bg-center p-6 lg:p-8 z-10">
                    <img class="absolute w-full h-full left-0 top-0 object-cover -z-10"
                         src="{{ $article->heroImage(2000,384) }}"
                         alt="Article Hero Image"
                         onerror="
                            this.onerror=null
                            this.src=''"
                    >
                    <div class="absolute inset-0 bg-linear-to-b from-black/40 to-black/40 -z-10"></div>
                    <div class="flex items-center justify-between mb-28 text-sm lg:text-base">
                        <a href="{{ route('articles') }}" class="flex items-center text-white hover:underline">
                            <x-heroicon-s-arrow-left class="w-4 h-4 fill-current" />
                            <span class="text-white ml-1 hover:text-gray-100">Back to articles</span>
                        </a>

                        <div>
                            @if ($article->isNotPublished())
                                <x-light-tag>
                                    @if ($article->isAwaitingApproval())
                                        Awaiting Approval
                                    @else
                                        Draft
                                    @endif
                                </x-light-tag>
                            @endif
                        </div>
                    </div>

                    @if (count($tags = $article->tags()))
                        <div class="flex flex-wrap gap-2 lg:gap-x-4 mb-4">
                            @foreach ($tags as $tag)
                                <a href="{{ route('articles', ['tag' => $tag->slug()]) }}">
                                    <x-light-tag :tag="$tag" class="hover:underline">
                                        {{ $tag->name() }}
                                    </x-light-tag>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <h1 class="text-white text-5xl font-bold mb-4 break-words">
                        {{ $article->title() }}
                    </h1>

                    <div class="flex flex-col gap-y-2 space-x-5 text-white lg:flex-row lg:items-center">
                        <div class="flex items-center space-x-1">
                            <x-avatar :user="$article->author()" class="w-6 h-6 rounded-full mr-1" />

                            <a href="{{ route('profile', $article->author()->username()) }}" class="hover:underline">
                                <span>{{ $article->author()->name() }}</span>
                            </a>

                            @if ($article->author()->isVerifiedAuthor())
                                <x-badges.verified type="o" color="text-white" />
                            @endif
                        </div>

                        <div class="flex items-center gap-x-6">
                            <span class="text-sm lg:mt-0">
                                {{ $article->createdAt()->format('j M, Y') }}
                            </span>

                            <span class="text-sm">
                                {{ $article->readTime() }} min read
                            </span>

                            @unless($article->view_count < 10)
                                <span class="text-sm">
                                    {{ $article->viewCount() }} views
                                </span>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>

            @if ($article->hasHeroImageAuthor())
                <p class="text-xs text-black/50 text-center mt-2">
                    Photo by <a class="underline font-medium" href="{{ $article->hero_image_author_url }}?ref=laravel.io&utm_source=Laravel.io&utm_medium=referral" target="_blank">{{ $article->hero_image_author_name }} </a> on <a class="underline font-medium" href="https://unsplash.com/?ref=laravel.io&utm_source=Laravel.io&utm_medium=referral" target="_blank">Unsplash</a>
                </p>
            @endif
        </div>

        <div class="container mx-auto">
            <div class="flex px-4 lg:px-0 lg:mx-48">
                <div class="hidden lg:block lg:w-1/5">
                    <div class="py-12 mt-48 sticky top-0">
                        <x-articles.engage :article="$article" />
                    </div>
                </div>

                <div class="w-full pt-4 lg:w-4/5 lg:pt-10">
                    @if (! $article->isDeclined() || $article->isAuthoredBy(Auth::user()))
                        <x-articles.actions :article="$article" />
                    @endif

                    <div
                        x-data="{}"
                        x-init="$nextTick(function () { highlightCode($el); })"
                        class="prose prose-lg text-gray-800 prose-lio"
                    >
                        {!! md_to_html($article->body(), ['nofollow' => false]) !!}
                    </div>

                    @if ($article->isUpdated())
                        <div class="text-sm text-gray-900 py-6">
                            Last updated {{ $article->updated_at->diffForHumans() }}.
                        </div>
                    @endif

                    <div class="flex items-center gap-x-6 pt-6 pb-10">
                        <livewire:like-article :article="$article" :isSidebar="false" />

                        <div class="flex flex-col text-gray-900 text-xl font-semibold">
                            Like this article?
                            <span class="text-lg font-medium">
                                Let the author know and give them a clap!
                            </span>
                        </div>
                    </div>

                    <div class="border-t-2 border-gray-200 py-8 lg:pt-14 lg:pb-16">
                        <div class="flex flex-col items-center justify-center gap-y-4 gap-x-6 lg:flex-row lg:justify-between">
                            <div class="flex items-start gap-x-4">
                                <div class="shrink-0">
                                    <x-avatar :user="$article->author()" class="hidden w-16 h-16 lg:block" />
                                </div>

                                <div class="flex flex-col items-center text-gray-900 text-xl font-semibold lg:items-start">
                                    <span class="flex items-center gap-x-1">
                                        <a href="{{ route('profile', $article->author()->username()) }}" class="hover:underline">
                                            {{ $article->author()->username() }} ({{ $article->author()->name() }})
                                        </a>

                                        @if ($article->author()->isVerifiedAuthor())
                                            <x-badges.verified color="text-lio-500" />
                                        @endif
                                    </span>

                                    <span class="text-lg text-gray-700 font-medium">
                                        {{ $article->author()->bio() }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-x-4">
                                @if ($article->author()->githubUsername())
                                    <a href="https://github.com/{{ $article->author()->githubUsername() }}">
                                        <x-icon-github class="w-6 h-6" />
                                    </a>
                                @endif

                                @if ($article->author()->hasTwitterAccount())
                                    <a href="https://twitter.com/{{ $article->author()->twitter() }}" class="text-twitter">
                                        <x-si-x class="w-6 h-6" />
                                    </a>
                                @endif

                                @if ($article->author()->hasBlueskyAccount())
                                    <a href="https://bsky.app/profile/{{ $article->author()->bluesky() }}" class="text-twitter">
                                        <x-icon-bluesky class="w-6 h-6" />
                                    </a>
                                @endif

                                @if ($article->author()->hasWebsite())
                                    <a href="{{ $article->author()->website() }}">
                                        <x-heroicon-o-globe-alt class="w-6 h-6" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <section>
        <div class="container mx-auto py-6 px-4 lg:py-24">
            <h2 class="text-4xl text-gray-900 font-bold">
                Other articles you might like
            </h2>

            <div class="flex flex-col gap-y-4 gap-x-6 mt-6 lg:flex-row lg:mt-12">
                @foreach ($trendingArticles as $trendingArticle)
                    <x-articles.summary
                        :article="$trendingArticle"
                        is-featured
                    />
                @endforeach
            </div>
        </div>
    </section>

    @can(App\Policies\ArticlePolicy::APPROVE, $article)
        @if ($article->isAwaitingApproval())
            <x-modal
                identifier="approveArticle"
                :action="route('admin.articles.approve', $article->slug())"
                title="Approve article"
                type="update"
            >
                <p>Are you sure you want to approve this article?</p>
            </x-modal>
        @endif
    @endcan

    @can(App\Policies\ArticlePolicy::DISAPPROVE, $article)
        @if ($article->isPublished())
            <x-modal
                identifier="unpublishArticle"
                :action="route('admin.articles.disapprove', $article->slug())"
                title="Unpublish article"
                type="update"
            >
                <p>Are you sure you want to unpublish this article? Doing so will mean it is no longer live on the site.</p>
            </x-modal>
        @endif
    @endcan

    @can(App\Policies\ArticlePolicy::DECLINE, $article)
        @if ($article->isNotDeclined())
            <x-modal
                identifier="declineArticle"
                :action="route('admin.articles.decline', $article->slug())"
                title="Decline article"
                type="update"
            >
                <p>Are you sure you want to decline this article? Doing so will permanently remove it from the review queue.</p>
            </x-modal>
        @endif
    @endcan

    @can(App\Policies\ArticlePolicy::DELETE, $article)
        <x-modal
            identifier="deleteArticle"
            :action="route('articles.delete', $article->slug())"
            title="Delete article"
        >
            <p>Are you sure you want to delete this article? Doing so will mean it is permanently removed from the site.</p>
        </x-modal>
    @endcan

    @can(App\Policies\ArticlePolicy::PINNED, $article)
        <x-modal
            identifier="togglePinnedStatus"
            :action="route('admin.articles.pinned', $article->slug())"
            :title="$article->isPinned() ? 'Unpin article' : 'Pin article'"
            type="update"
        >
            @if ($article->isPinned())
                <p>Are you sure you want to unpin this article?</p>
            @else
                <p>Are you sure you want to pin this article?</p>
            @endif
        </x-modal>
    @endcan
@endsection
