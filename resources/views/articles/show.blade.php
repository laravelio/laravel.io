@title($article->title())

@extends('layouts.default')

@push('meta')
<link rel="canonical" href="{{ $article->canonicalUrl() }}" />
@endpush

@section('content')
    <div class="max-w-screen-md mx-auto p-4 pt-8">
        <h1 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:leading-none mb-4">{{ $article->title() }}</h1>
        @if ($article->isNotPublished())
            <span class="label inline-flex mb-4">
                Draft
            </span>
        @endif
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
                        <time datetime="{{ $article->publishedAt()->format('Y-m-d') }}">
                            {{ $article->publishedAt()->format('j M, Y') }}
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
    </div>
@endsection