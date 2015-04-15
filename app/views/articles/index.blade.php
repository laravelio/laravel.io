@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('articles._sidebar')
@stop

@section('content')
    <div class="header">
        <h1>Articles</h1>
            {{-- Display select tags --}}
            @if(Input::get('tags'))
                <div class="tags">
                    {{{ Input::get('tags') }}}
                </div>
            @endif
    </div>

    <section class="padding articles">
        @if($articles->count() > 0)
            @foreach($articles as $article)
                @include('articles._summary')
            @endforeach

            {{ $articles->links() }}
        @else
            <div class="empty-state">
                <h3>There are currently no articles for the selected category.</h3>
            </div>
        @endif
    </section>
@stop
