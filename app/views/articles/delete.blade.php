@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('articles._sidebar')
@stop

@section('content')
    <div class="header">
        <h1>Delete Your Article?</h1>
    </div>

    <div class="reply-form">
        {{ Form::model($article->resource) }}
        <div class="form-row">
            <label class="field-title">Are you sure that you want to delete this article?</label>
        </div>

        <div class="form-row">
            {{ Form::button('Delete', ['type' => 'submit', 'class' => 'button']) }}
        </div>
    </div>
@stop
