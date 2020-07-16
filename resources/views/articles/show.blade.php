@title($article->title())
@shareImage(route('articles.image', $article->slug()))

@extends('layouts.default')

@push('meta')
<link rel="canonical" href="{{ $article->canonicalUrl() }}" />
@endpush

@section('content')
    <div class="max-w-screen-md mx-auto px-4 py-8 mb-8">
        <h1 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:leading-none mb-4">{{ $article->title() }}</h1>

        @if (Auth::check() && $article->isAuthoredBy(Auth::user()))
            <a href="{{ route('articles.edit', $article->slug()) }}" class="label label-primary inline-flex">
                Edit
            </a>
        @endif
        
        @if ($article->isNotPublished())
            @if($article->isAwaitingApproval())
                <span class="label inline-flex mb-4">
                    Awaiting Approval
                </span>
                @can(App\Policies\ArticlePolicy::APPROVE, $article)
                    <button type="button" class="label label-primary inline-flex mb-4" @click.prevent="activeModal = 'approveArticle'">
                        Approve
                    </button>
                @endcan
            @else
                <span class="label inline-flex mb-4">
                    Draft
                </span>
            @endif
            
        @else
            @can(App\Policies\ArticlePolicy::DISAPPROVE, $article)
                <button type="button" class="label label-danger inline-flex mb-4" @click.prevent="activeModal = 'disapproveArticle'">
                    Disapprove
                </button>
            @endcan
        @endif

        @can(App\Policies\ArticlePolicy::DELETE, $article)
            <button type="button" class="label label-danger inline-flex mb-4" @click.prevent="activeModal = 'deleteArticle'">
                Delete
            </button>
        @endcan

        @can(App\Policies\ArticlePolicy::PINNED, $article)
            <button type="button" class="label inline-flex mb-4" @click.prevent="activeModal = 'togglePinnedStatus'">
                {{ $article->isPinned() ? 'Unpin' : 'Pin' }}
            </button>
        @endcan

        <div class="mb-8 text-gray-700 flex items-center">
            @include('forum.threads.info.avatar', ['user' => $article->author(), 'size' => 50])
            <div class="mr-12">
                <p class="text-sm leading-5 font-medium text-gray-900">
                    <a href="#">
                        {{ $article->author()->name() }}
                    </a>
                </p>
                <div class="flex text-sm leading-5 text-gray-500">
                    @if($article->isPublished())
                        <time datetime="{{ $article->submittedAt()->format('Y-m-d') }}">
                            {{ $article->submittedAt()->format('j M, Y') }}
                        </time>
                        <span class="mx-1">
                            &middot;
                        </span>
                    @endif
                    <span>
                        {{ $article->readTime() }} min read
                    </span>
                </div>
            </div>
            <livewire:like-article :article="$article" />
        </div>
        <div 
            class="article text-lg"
            x-data="{}" 
            x-init="function () { highlightCode($el); }"
        >
            {!! md_to_html($article->body()) !!}
        </div>
        <livewire:like-article :article="$article"/>
        <span class="text-gray-500 text-sm">
            Like this article?<br>Let the author know and give them a clap!
        </span>
        @include('articles._series_nav')
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
