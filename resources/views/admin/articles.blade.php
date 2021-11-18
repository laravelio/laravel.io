@title('Articles')

@extends('layouts.default')

@section('content')
    <div class="container mx-auto px-4 pt-6">
        @include('admin.partials._navigation', [
            'query' => route('admin'),
            'search' => $adminSearch,
            'placeholder' => 'Search for articles...',
        ])
    </div>

    <main class="container mx-auto pb-10 lg:py-6 sm:px-4">
        <div class="flex flex-col">
            @if($articles->isNotEmpty())
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <x-tables.table-head>Author</x-tables.table-head>
                                        <x-tables.table-head>Title</x-tables.table-head>
                                        <x-tables.table-head>Submitted on</x-tables.table-head>
                                        <x-tables.table-head class="text-center">View</x-tables.table-head>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($articles as $article)
                                        <tr>
                                            <x-tables.table-data>
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <x-avatar :user="$article->author()" class="h-10 w-10 rounded-full"/>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a href="{{ route('profile', $article->author()->username()) }}">
                                                                {{ $article->author()->name() }}
                                                            </a>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            <a href="{{ route('profile', $article->author()->username()) }}">
                                                                {{ $article->author()->username() }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </x-tables.table-data>

                                            <x-tables.table-data>
                                                {{ $article->title() }}
                                            </x-tables.table-data>

                                            <x-tables.table-data>
                                                {{ $article->submittedAt()->format('j M Y H:i:s') }}
                                            </x-tables.table-data>

                                            <x-tables.table-data class="text-center w-10">
                                                <a
                                                    href="{{ route('articles.show', $article->slug()) }}"
                                                    class="text-lio-600 hover:text-lio-800"
                                                >
                                                    <x-heroicon-o-eye class="w-5 h-5 inline" />
                                                </a>
                                            </x-tables.table-data>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <x-empty-state title="No articles has been posted yet" icon="heroicon-o-document-text" />
            @endif
        </div>

        <div class="p-4">
            {{ $articles->render() }}
        </div>
    </main>
@endsection
