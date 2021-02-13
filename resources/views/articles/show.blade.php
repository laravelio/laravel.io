@title($article->title())
@shareImage(route('articles.image', $article->slug()))

@extends('layouts.default')

@push('meta')
    <link rel="canonical" href="{{ $article->canonicalUrl() }}" />
@endpush

@section('content')
    <div class="relative pt-16 bg-white">
        <div class="text-lg max-w-prose mx-auto">
            <h1>
                <span class="block text-3xl sm:text-4xl text-center leading-8 font-extrabold tracking-tight text-gray-900">
                    {{ $article->title() }}
                </span>
            </h1>
        </div>

        <div class="flex flex-col items-center mt-8">
            <div class="flex items-center justify-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('profile', $article->author()->username()) }}">
                        <span class="sr-only">
                            {{ $article->author()->name() }}
                        </span>

                        <x-avatar :user="$article->author()" class="h-10 w-10 rounded-full" />
                    </a>
                </div>

                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">
                        <a href="{{ route('profile', $article->author()->username()) }}" class="hover:underline">
                            {{ $article->author()->name() }}
                        </a>
                    </p>

                    <div class="flex space-x-1 text-sm text-gray-500">
                        @if ($article->isPublished())
                            <time datetime="{{ $article->submittedAt()->format('Y-m-d') }}">
                                {{ $article->submittedAt()->format('j M, Y') }}
                            </time>

                            <span aria-hidden="true">
                                &middot;
                            </span>
                        @endif

                        <span>
                            {{ $article->readTime() }} min read
                        </span>
                    </div>
                </div>
            </div>

            @if ($article->isNotPublished())
                <div class="mt-6">
                    <x-badges.badge>
                        @if ($article->isAwaitingApproval())
                            Awaiting Approval
                        @else
                            Draft
                        @endif
                    </x-badges.badge>
                </div>
            @endif
        </div>

        <div class="flex flex-col md:flex-row mx-auto justify-center bg-white">
            <div class="md:sticky md:top-0 md:self-start pt-6 md:pt-14 w-full md:w-16">
                @include('articles._sidebar')
            </div>

            <div
                x-data="{}"
                x-init="function () { highlightCode($el); }"
                class="prose prose-lg text-gray-500 prose-lio px-4"
            >
                <x-buk-markdown>{!! $article->body() !!}</x-buk-markdown>

                <div class="flex items-center pt-6 pb-10">
                    <livewire:like-article :article="$article" />

                    <span class="text-gray-500 text-sm ml-2">
                        Like this article?<br>
                        Let the author know and give them a clap!
                    </span>
                </div>

                @include('articles._series_nav')
            </div>
        </div>
    </div>

    @can(App\Policies\ArticlePolicy::APPROVE, $article)
        @if ($article->isAwaitingApproval())
            @include('_partials._update_modal', [
                'identifier' => 'approveArticle',
                'route' => ['admin.articles.approve', $article->slug()],
                'title' => "Approve article",
                'body' => '<p>Are you sure you want to approve this article?</p>',
            ])
        @endif
    @endcan

    @can(App\Policies\ArticlePolicy::DISAPPROVE, $article)
        @if ($article->isPublished())
            @include('_partials._update_modal', [
                'identifier' => 'disapproveArticle',
                'route' => ['admin.articles.disapprove', $article->slug()],
                'title' => "Disapprove article",
                'body' => '<p>Are you sure you want to disapprove this article? Doing so will mean it is no longer live on the site.</p>',
            ])
        @endif
    @endcan

    @can(App\Policies\ArticlePolicy::DELETE, $article)
        @include('_partials._delete_modal', [
            'identifier' => 'deleteArticle',
            'route' => ['articles.delete', $article->slug()],
            'title' => "Delete article",
            'body' => '<p>Are you sure you want to delete this article? Doing so will mean it is permanently removed from the site.</p>',
        ])
    @endcan

    @can(App\Policies\ArticlePolicy::PINNED, $article)
        @include('_partials._update_modal', [
            'identifier' => 'togglePinnedStatus',
            'route' => ['admin.articles.pinned', $article->slug()],
            'title' => $article->isPinned() ? "Unpin article" : "Pin article",
            'body' => $article->isPinned() ? '<p>Are you sure you want to unpin this article?</p>' : '<p>Are you sure you want to pin this article?</p>',
        ])
    @endcan
@endsection
