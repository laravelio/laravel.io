@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('articles._sidebar')
@stop

@section('content')
    <section id="articles" class="articles">
        <h2>Articles</h2>

        @if($articles->count() > 0)
            @foreach($articles as $article)
                @include('articles._summary')
            @endforeach

            {{ $articles->links() }}
        @else
            <div class="">
                There are currently no articles for the selected category.
            </div>
        @endif
    </section>
@stop