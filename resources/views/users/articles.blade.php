@title('Your Articles')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900 break-all">
                {{ $title }}
            </h1>

            <div class="flex">
                <x-buttons.primary-button href="{{ route('articles.create') }}">
                    Create Article
                </x-buttons.primary-button>
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

        <div class="flex flex-col gap-y-4">
            @forelse($articles as $article)
                <x-articles.overview-summary :article="$article" :mode="'edit'"/>
            @empty
                <p class="text-gray-600 text-base">
                    You haven't created any articles yet
                </p>
            @endforelse
        </div>

        {{ $articles->links() }}
    </div>
@endsection
