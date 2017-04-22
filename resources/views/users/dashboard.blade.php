@title('Dashboard')

@extends('layouts.default')

@section('content')
    <h1>Welcome {{ Auth::user()->name() }}!</h1>
    <hr>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default panel-counter">
                <div class="panel-heading">Threads</div>
                <div class="panel-body">{{ Auth::user()->countThreads() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default panel-counter">
                <div class="panel-heading">Replies</div>
                <div class="panel-body">{{ Auth::user()->countReplies() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default panel-counter">
                <div class="panel-heading">Solutions</div>
                <div class="panel-body">{{ Auth::user()->countSolutions() }}</div>
            </div>
        </div>
    </div>


    @include('users._latest_content', ['user' => Auth::user()])
@endsection
