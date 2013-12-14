@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('articles._sidebar')
@stop

@section('content')
    <div class="row forum">
        <div class="small-12 columns form">
            {{ Form::model($article->resource) }}
                <fieldset>
                    <legend>Edit Article</legend>
                    @include('articles._article_form')
                </fieldset>
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/vendor/tabby.js') }}"></script>
    <script src="{{ asset('javascripts/forums.js') }}"></script>
@stop