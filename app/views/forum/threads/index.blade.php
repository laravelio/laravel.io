@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <section class="forum">
        <div class="header">
            <h1>Forum</h1>
                {{-- Display select tags --}}
                @if(Input::get('tags', null))
                    <div class="tags">
                        {{ Input::get('tags') }}
                    </div>
                @endif
            <a class="button" href="{{ action('ForumThreadsController@getCreateThread') }}">Create Thread</a>
        </div>

        <div class="threads">
            {{-- Loop over the threads and display the thread summary partial --}}
            @each('forum.threads._index_summary', $threads, 'thread')

            {{-- If no comments are found display a message --}}
            @if( ! $threads->count())
                <div class="empty-state">
                    @if(Input::get('tags'))
                        <h3>No threads found that are tagged with {{ Input::get('tags') }}</h3>
                    @else
                        <h3>No threads found.</h3>
                    @endif
                    <a class="button" href="{{ action('ForumThreadsController@getCreateThread') }}">Create a new thread</a>
                </div>
            @endif
        </div>

        <div class="pagination">
            {{ $threads->links() }}
        </div>
    </section>
@stop
