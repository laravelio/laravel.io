@title('My Series')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">
                {{ $title }}
            </h1>
            <div class="flex">
                <a href="{{ route('series.create') }}" class="button mr-2">
                    Create Series
                </a>
                <a href="{{ route('articles.create') }}" class="button button-primary">
                    Create Article
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8 flex flex-wrap flex-col-reverse lg:flex-row">
        <div class="w-full md:w-3/4 md:pr-3">
            @forelse ($series as $set)
                <div class="thread-card">
                    <div class="flex justify-between mb-4">
                        <a href="{{ route('series.edit', $set->slug()) }}">
                            <h4 class="text-xl font-bold text-gray-700">
                                {{ $set->title() }}
                            </h4>
                        </a>
                        {{ $set->articles->count() }} {{ Str::plural('article', $set->articles->count()) }} in series
                    </div>
                    <div class="flex">
                        @if($set->tags()->count())
                            <div class="w-full flex justify-start">
                                @foreach ($set->tags() as $tag)
                                    <a href="{{ route('articles', ['tag' => $tag->slug()]) }}">
                                        <span class="bg-gray-300 text-gray-700 rounded px-2 py-1">{{ $tag->name() }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        <div class="w-full flex justify-end">
                            <a href="{{ route('series.edit', $set->slug()) }}">
                                <span class="bg-lio-500 text-white rounded px-2 py-1">
                                    Edit
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 text-base">
                    You haven't created any series yet
                </p>
            @endforelse
        </div>
        <div class="w-full md:w-1/4 md:pl-3 md:pt-4">
            @include('users.partials._navigation')
        </div>
    </div>
@endsection
