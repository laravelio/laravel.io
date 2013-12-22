@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('articles._sidebar', ['query' => $query])
@stop

@section('content')
    <section class="forum">
        <div class="header">
            @if($query)
                <h1>Article Search results for "{{ $query }}"</h1>
            @else
                <h1>Article Search</h1>
            @endif
        </div>

        @if($query)
            <div class="threads">
                @if($results->count() > 0)
                    {{-- Loop over the threads and display the thread summary partial --}}
                    @foreach($results as $result)
                            @include('articles._summary', ['article' => $result])
                    @endforeach
                @else
                    {{-- If no comments are found display a message --}}
                    <div class="empty-state">
                        <h3>No results found in the articles for "{{ $query }}"</h3>
                    </div>
                @endif
            </div>

            <div class="pagination">
                {{ $results->appends(array('query' => $query))->links() }}
            </div>
        @else
            <div class="padding">
                {{ Form::open(['action' => 'ArticlesController@getSearch', 'method' => 'GET']) }}
                    <div class="form-row">
                        {{ Form::label('query', 'Search the laravel.io articles', ['class' => 'field-title']) }}
                        {{ Form::text('query', null, ['placeholder' => 'search the laravel.io articles'] )}}
                    </div>
                    <div class="form-row">
                    {{ Form::button('Go Find Stuff!', ['type' => 'submit', 'class' => 'button']) }}
                    </div>
                {{ Form::close() }}
            </div>
        @endif
    </section>
@stop