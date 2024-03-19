@title('Replies')

@extends('layouts.default')

@section('content')
    <div class="container mx-auto px-4 pt-6">
        @include('admin.partials._navigation', [
            'query' => route('admin.replies'),
            'search' => $adminSearch,
            'placeholder' => 'Search for replies...',
        ])
    </div>

    <main class="container mx-auto pb-10 sm:px-4 lg:py-6">
        <div class="flex flex-col">
            @if ($replies->isNotEmpty())
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <x-tables.table-head>Author</x-tables.table-head>
                                        <x-tables.table-head>Thread</x-tables.table-head>
                                        <x-tables.table-head>Content</x-tables.table-head>
                                        <x-tables.table-head>Updated</x-tables.table-head>
                                        <x-tables.table-head class="text-center">View</x-tables.table-head>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($replies as $reply)
                                        <tr>
                                            <x-tables.table-data>
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 shrink-0">
                                                        <x-avatar
                                                            :user="$reply->author()"
                                                            class="h-10 w-10 rounded-full"
                                                        />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a href="{{ route('profile', $reply->author()->username()) }}">
                                                                {{ $reply->author()->name() }}
                                                            </a>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            <a href="{{ route('profile', $reply->author()->username()) }}">
                                                                {{ $reply->author()->username() }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </x-tables.table-data>

                                            <x-tables.table-data>
                                                {{ $reply->replyAble()->subject() }}
                                            </x-tables.table-data>

                                            <x-tables.table-data>
                                                {{ $reply->excerpt() }}
                                            </x-tables.table-data>

                                            <x-tables.table-data>
                                                @if ($reply->updatedBy())
                                                    <span class="inline-flex items-center rounded-full bg-lio-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                                        YES
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                                        NO
                                                    </span>
                                                @endif
                                            </x-tables.table-data>

                                            <x-tables.table-data class="w-10 text-center">
                                                <a
                                                    href="{{ route('thread', $reply->replyAble()->slug()) }}#{{ $reply->id() }}"
                                                    class="text-lio-600 hover:text-lio-800"
                                                >
                                                    <x-heroicon-o-eye class="inline h-5 w-5" />
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
                <x-empty-state title="No replies have been posted yet" icon="heroicon-o-document-text" />
            @endif
        </div>

        <div class="p-4">
            {{ $replies->render() }}
        </div>
    </main>
@endsection
