@title('Edit your article')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">
                <a href="{{ route('user.articles') }}">Your Articles</a>
                > {{ $title }}
            </h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto p-4 flex justify-center">
        <div class="w-full md:w-2/3 xl:w-1/2">
            <x-rules-banner />

            <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100">
                @include('articles._form', [
                    'route' => ['articles.update', $article->slug()],
                    'method' => 'PUT',
                ])
            </div>

            <x-forms.info>
                After submission for approval, articles are reviewed before being published. No notification of declined articles will be provided. Instead, we encourage to also cross-post articles on your own channel as well.
            </x-forms.info>
        </div>
    </div>
@endsection
