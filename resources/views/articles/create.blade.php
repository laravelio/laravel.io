@title('Write your article')

@extends('layouts.default')

@section('subnav')
    <div class="border-b bg-white">
        <div class="container mx-auto flex items-center justify-between px-4">
            <h1 class="py-4 text-xl text-gray-900">
                <a href="{{ route('user.articles') }}">Your Articles</a>
                >
                <span class="break-all">{{ $title }}</span>
            </h1>
        </div>
    </div>
@endsection

@section('content')
    <main class="mx-auto max-w-4xl px-4 pb-12 pt-10 lg:pb-16">
        <div class="lg:grid lg:gap-x-5">
            <div class="sm:px-6 lg:col-span-9 lg:px-0">
                <x-articles.form :route="['articles.store']" :tags="$tags" :selectedTags="$selectedTags" />
            </div>
        </div>
    </main>
@endsection
