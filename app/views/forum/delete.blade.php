@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
<div class="header">
    <h1>Delete Your {{ $comment->isMainComment() ? 'Thread' : 'Reply' }}</h1>
</div>

    <div class="reply-form">
        {{ Form::model($comment->resource) }}
            <div class="form-row">
                <label class="field-title">Are you sure that you want to delete this {{ $comment->isMainComment() ? 'thread' : 'reply' }}?</label>
            </div>

            <div class="form-row">
                {{ Form::button('Delete', ['type' => 'submit', 'class' => 'button']) }}
            </div>
    </div>
@stop

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/forums.js') }}"></script>
@stop