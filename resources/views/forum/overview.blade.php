@php($subTitle = isset($activeTag) ? $activeTag->name() : null)
@title('Forum' . (isset($subTitle) ? ' > ' . $subTitle : ''))

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <hr>

    <div class="row forum">
        <div class="col-md-3">
            {{ Form::open(['route' => 'forum', 'method' => 'GET']) }}
                <div class="form-group">
                    {{ Form::text('search', $search ?? null, ['class' => 'form-control', 'placeholder' => 'Search for threads...']) }}
                </div>
            {{ Form::close() }}

            <a class="btn btn-success btn-block" href="{{ route('threads.create') }}">Create Thread</a>

            @include('layouts._ads._forum_sidebar')

            <h3>Tags</h3>
            <div class="list-group">
                <a href="{{ route('forum') }}" class="list-group-item {{ active('forum*', ! isset($activeTag) || $activeTag === null) }}">All</a>

                @foreach (App\Models\Tag::orderBy('name')->get() as $tag)
                    <a href="{{ route('forum.tag', $tag->slug()) }}"
                       class="list-group-item{{ isset($activeTag) && $tag->matches($activeTag) ? ' active' : '' }}">
                        {{ $tag->name() }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            @include('layouts._ads._carbon')

            @if (count($threads))
                @foreach ($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading thread-info">
                            @if (count($thread->replies()))
                                @include('forum.threads.info.avatar', ['user' => $thread->replies()->last()->author()])
                            @else
                                @include('forum.threads.info.avatar', ['user' => $thread->author()])
                            @endif

                            <div class="thread-info-author">
                                @if (count($thread->replies()))
                                    @php($lastReply = $thread->replies()->last())
                                    <a href="{{ route('profile', $lastReply->author()->username()) }}" class="thread-info-link">{{ $lastReply->author()->name() }}</a> replied
                                    {{ $lastReply->createdAt()->diffForHumans() }}
                                @else
                                    <a href="{{ route('profile', $thread->author()->username()) }}" class="thread-info-link">{{ $thread->author()->name() }}</a> posted
                                    {{ $thread->createdAt()->diffForHumans() }}
                                @endif
                            </div>

                            @include('forum.threads.info.tags')
                        </div>

                        <div class="panel-body">
                            <a href="{{ route('thread', $thread->slug()) }}">
                                <span class="badge pull-right">{{ count($thread->replies()) }}</span>
                                <h4 class="media-heading">{{ $thread->subject() }}</h4>
                                <p>{{ $thread->excerpt() }}</p>
                            </a>
                        </div>
                    </div>
                @endforeach

                <div class="text-center">
                    {!! $threads->render() !!}
                </div>
            @else
                <div class="alert alert-info text-center">
                    No threads were found!
                    <a href="{{ route('threads.create') }}" class="alert-link">Create a new one.</a>
                </div>
            @endif
        </div>
    </div>
@endsection
