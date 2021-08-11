@title('Create your thread')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">
                <a href="{{ route('forum') }}">Forum</a>
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
                @include('forum.threads._form', [
                    'route' => ['threads.store'],
                ])
            </div>

            <x-forms.info>
                Please search for your question before posting your thread by using the search box in the navigation bar.
            </x-forms.info>
        </div>
    </div>
@endsection
