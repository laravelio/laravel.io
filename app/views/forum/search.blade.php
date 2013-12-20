@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <section class="forum">
        <div class="header">
            @if($query)
                <h1>Forum Search results for "{{ $query }}"</h1>
            @else
                <h1>Forum Search</h1>
            @endif
        </div>

        @if($query)
            <div class="threads">
                @if($results->count() > 0)
                    {{-- Loop over the threads and display the thread summary partial --}}
                    @foreach($results as $result)
                        @if($result->parent)
                            @include('forum._thread_summary', ['thread' => $result->parent])
                        @else
                            @include('forum._thread_summary', ['thread' => $result])
                        @endif
                    @endforeach
                @else
                    {{-- If no comments are found display a message --}}
                    <div class="empty-state">
                        <h3>No results found on the forum for "{{ $query }}"</h3>
                    </div>
                @endif
            </div>

            <div class="pagination">
                {{ $results->links() }}
            </div>
        @else
            {{ Form::open(['action' => 'ForumController@getSearch', 'method' => 'GET']) }}
            {{ Form::text('query', null, ['placeholder' => 'search the laravel.io forum'] )}}
            {{ Form::close() }}
        @endif
    </section>
@stop