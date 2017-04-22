@php($subTitle = isset($activeTag) ? $activeTag->name() : null)
@title('Forum' . (isset($subTitle) ? ' > ' . $subTitle : ''))

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <hr>

    <div class="row">
        <div class="col-md-3">
            <a class="btn btn-success btn-block" href="{{ route('threads.create') }}">Create Thread</a>

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

                        @include('forum.threads._footer')
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
