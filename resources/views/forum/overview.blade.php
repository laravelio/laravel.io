@title('Forum')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}{{ isset($activeTopic) ? ' > ' . $activeTopic->name() : '' }}</h1>

    <hr>

    <div class="row">
        <div class="col-md-3">
            <a class="btn btn-success btn-block" href="{{ route('threads.create') }}">Create Thread</a>

            <h3>Topics</h3>

            <div class="list-group">
                <a href="{{ route('forum') }}" class="list-group-item {{ active('forum') }}">All</a>

                @foreach ($topics as $topic)
                    <a href="{{ route('forum.topic', $topic->slug()) }}"
                       class="list-group-item{{ isset($activeTopic) && $topic->matches($activeTopic) ? ' active' : '' }}">
                        {{ $topic->name() }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            @if (count($threads))
                @foreach ($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{ route('profile', $thread->author()->username()) }}">
                                        <img class="media-object img-circle" src="{{ $thread->author()->gratavarUrl(45) }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="{{ route('thread', $thread->slug()) }}">
                                        <span class="badge pull-right">{{ count($thread->replies()) }}</span>
                                        <h4 class="media-heading">{{ $thread->subject() }}</h4>
                                        <p>{{ $thread->excerpt() }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a href="{{ route('forum.topic', $thread->topic()->slug()) }}">
                                <span class="label label-default">{{ $thread->topic()->name() }}</span>
                            </a>
                            | Posted {{ $thread->createdAt()->diffForHumans() }} ago by
                            <a href="{{ route('profile', $thread->author()->username()) }}">{{ $thread->author()->name() }}</a>
                        </div>
                    </div>
                @endforeach

                <div class="text-center">
                    {!! $threads->render() !!}
                </div>
            @else
                <div class="alert alert-info text-center">
                    No threads were found! <a href="{{ route('threads.create') }}" class="alert-link">Create a new one.</a>
                </div>
            @endif
        </div>
    </div>
@endsection
