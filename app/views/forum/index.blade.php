@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <section class="forum">
        <div class="header">
            <h1>Forum</h1>
                {{-- Display select tags --}}
                @if(Input::get('tags'))
                    <div class="tags">
                        {{ Input::get('tags') }}
                    </div>
                @endif
            <a class="button" href="{{ action('ForumThreadController@create') }}">Create Thread</a>
        </div>

        <div class="threads">
            {{-- Loop over the threads and display the thread summary partial --}}
            @each('forum._thread_summary', $threads, 'thread')

            {{-- If no comments are found display a message --}}
            @if(!$threads->count())
                <div class="empty-state">
                    <h3>No threads found that are tagged with {{ Input::get('tags') }}</h3>
                    <a class="button" href="{{ action('ForumThreadController@create') }}">Create a new thread</a>
                </div>
            @endif
        </div>

        <div class="pagination">
            {{ $threads->links() }}
        </div>
    </section>
@stop