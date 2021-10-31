@title('Your Articles')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900 break-all">
                {{ $title }}
            </h1>

            <div class="flex">
                <a href="{{ route('articles.create') }}" class="button button-primary">
                    Create Article
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        @unless(Auth::user()->hasTwitterAccount())
            <div class="bg-lio-500 text-white text-sm p-3">
                <x-heroicon-s-information-circle class="h-5 w-5 inline-block mr-1" />

                Set your <a href="{{ route('settings.profile') }}" class="underline">Twitter handle</a> so we can link to your profile when we tweet out your article.
            </div>
        @endunless

        @forelse($articles as $article)
            <div class="pb-8 mb-8 border-b-2">
                <div>
                    @if ($article->isNotPublished())
                        <span class="label mr-2">
                            Draft
                        </span>
                    @endif

                    @foreach ($article->tags() as $tag)
                        <x-tag>
                            {{ $tag->name() }}
                        </x-tag>
                    @endforeach
                </div>

                <a href="{{ route('articles.show', $article->slug()) }}" class="block">
                    <div class="mt-4 flex justify-between items-center">
                        <h3 class="text-xl leading-7 font-semibold text-gray-900">
                            {{ $article->title() }}
                        </h3>

                        <div class="flex">
                            <a href="{{ route('articles.show', $article->slug()) }}" class="button mr-2">
                                View
                            </a>
                            <a href="{{ route('articles.edit', $article->slug()) }}" class="button button-primary">
                                Edit
                            </a>
                        </div>
                    </div>

                    <p class="mt-3 text-base leading-6 text-gray-500">
                        {{ $article->excerpt() }}
                    </p>
                </a>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-avatar :user="$article->author()" class="h-10 w-10 rounded-full"/>
                        </div>

                        <div class="ml-3">
                            <p class="text-sm leading-5 font-medium text-gray-900">
                                <a href="{{ route('profile', $article->author()->username()) }}" class="hover:underline">
                                    {{ $article->author()->name() }}
                                </a>
                            </p>

                            <div class="flex text-sm leading-5 text-gray-500">
                                @if ($article->isPublished())
                                    <time datetime="{{ $article->submittedAt()->format('Y-m-d') }}">
                                        Published {{ $article->submittedAt()->format('j M, Y') }}
                                    </time>
                                @else
                                    @if ($article->isAwaitingApproval())
                                        <span>
                                            Awaiting Approval
                                        </span>
                                    @else
                                        <time datetime="{{ $article->updatedAt()->format('Y-m-d') }}">
                                            Drafted {{ $article->updatedAt()->format('j M, Y') }}
                                        </time>
                                    @endif
                                @endif

                                <span class="mx-1">
                                    &middot;
                                </span>

                                <span>
                                    {{ $article->readTime() }} min read
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center text-gray-500">
                        <span class="text-2xl mr-2">👏</span>
                        {{ count($article->likes()) }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-base">
                You haven't created any articles yet
            </p>
        @endforelse

        {{ $articles->links() }}
    </div>
@endsection
