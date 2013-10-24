@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('articles._sidebar')
@stop

@section('content')
    <section class="articles">
        <h1>{{ $article->title }}</h1>
        <p>
            {{ $article->content }}
        </p>
    </section>
@stop