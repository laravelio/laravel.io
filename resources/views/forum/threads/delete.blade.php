@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <div class="header">
        <h1>Delete Your Thread?</h1>
    </div>

    <div class="reply-form">
        {!! Form::model($thread->getWrappedObject()) !!}
            <div class="form-row">
                <label class="field-title">Are you sure that you want to delete this thread?</label>
            </div>

            <div class="form-row">
                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'button'])!!}
            </div>
        {!! Form::close() !!}
    </div>
@stop
