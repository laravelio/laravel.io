@title('Notifications')

@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Notifications <button class="btn btn-xs btn-danger pull-right" @click="emitGlobal('MarkAllAsRead')">Mark all as read</button></div>
                <div class= "panel-body">
                    <notification-list :notifications="{{ Auth::user()->notifications()->get() }}"></notification-list>
                </div>
            </div>
        </div>
    </div>
@endsection
