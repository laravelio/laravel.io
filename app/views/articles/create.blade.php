@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('articles._sidebar')
@stop

@section('content')
    <div class="header">
        <h1>Compose Article</h1>
    </div>
    {{ Form::open() }}
        <section class="padding">
            @include('articles._article_form')
        </section>
    {{ Form::close() }}
@stop