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
        <div class="mr-6 mb-8 text-gray-700 flex items-center">
            @include('forum.threads.info.avatar', ['user' => $article->author(), 'size' => 50])
            <div>
                <a href="{{ route('profile', $article->author()->username()) }}"
                    class="text-green-darker mr-2">
                    {{ $article->author()->name() }}
                </a>
                <span class="block text-sm">published {{ $article->createdAt()->format('j M, Y') }}</span>
            </div>
        </div>
        <div 
            class="article text-lg"
            x-data="{}" 
            x-init="function () { highlightCode($el); }"
            x-html="{{ json_encode(md_to_html($article->body())) }}"
        >
    </div>
@endsection