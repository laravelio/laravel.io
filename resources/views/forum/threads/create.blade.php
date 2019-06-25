@title('Create your thread')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">
                <a href="{{ route('forum') }}">Forum</a>
                > {{ $title }}
            </h1>
            
            {{ Form::open(['route' => 'forum', 'method' => 'GET']) }}
                {{ Form::text('search', $search ?? null, ['class' => 'rounded border-2 border-gray-300 py-1 px-3 focus:outline-none focus:border-blue-900', 'placeholder' => 'Search for threads...']) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto p-4 flex justify-center">
        <div class="w-full md:w-2/3 xl:w-1/2">
            <div class="bg-gray-400 rounded p-2 mb-4 text-gray-700">
                <p>
                    Please try to search for your question first using
                    <a href="{{ route('forum') }}" class="text-green-darker">the search box</a> and make sure you've read our
                    <a href="{{ route('rules') }}" class="text-green-darker">Forum Rules</a> before creating a thread.
                </p>
            </div>

            <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100">

                @include('forum.threads._form', ['route' => 'threads.store'])

            </div>
        </div>
    </div>
@endsection
