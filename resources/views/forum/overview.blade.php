@php($subTitle = isset($activeTag) ? $activeTag->name() : null)
@title('Forum' . (isset($subTitle) ? ' > ' . $subTitle : ''))

@extends('layouts.default')

@section('content')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4">{{ $title }}</h1>
            
            {{ Form::open(['route' => 'forum', 'method' => 'GET']) }}
                {{ Form::text('search', $search ?? null, ['class' => 'rounded border-2 border-gray-300 py-1 px-3 focus:outline-none focus:border-blue-900', 'placeholder' => 'Search for threads...']) }}
            {{ Form::close() }}
        </div>
    </div>

    <div class="container mx-auto px-4 pt-4 flex flex-wrap">
        <div class="w-full md:w-3/4 md:pr-3">
            @include('layouts._ads._bsa-cpc')

            @if (count($threads))
                @foreach ($threads as $thread)
                    <div class="thread-card">
                        <div class="flex justify-between">
                            <a href="{{ route('thread', $thread->slug()) }}">
                                <h4 class="text-xl font-bold">{{ $thread->subject() }}</h4>
                                <p class="text-gray-500">{{ $thread->excerpt() }}</p>
                            </a>
                            <span class="">
                                <i class="fa fa-comment text-gray-500 mr-2"></i>
                                {{ count($thread->replies()) }}
                            </span>
                        </div>
                        <div class="flex items-center text-sm pt-5">
                            @if (count($thread->replies()))
                                @include('forum.threads.info.avatar', ['user' => $thread->replies()->last()->author()])
                            @else
                                @include('forum.threads.info.avatar', ['user' => $thread->author()])
                            @endif

                            <div class="mr-6 text-gray-700">
                                @if (count($thread->replies()))
                                    @php($lastReply = $thread->replies()->last())
                                    <a href="{{ route('profile', $lastReply->author()->username()) }}" class="text-green-500 mr-2">{{ $lastReply->author()->name() }}</a> replied
                                    {{ $lastReply->createdAt()->diffForHumans() }}
                                @else
                                    <a href="{{ route('profile', $thread->author()->username()) }}" class="text-green-500 mr-2">{{ $thread->author()->name() }}</a> posted
                                    {{ $thread->createdAt()->diffForHumans() }}
                                @endif
                            </div>

                            @include('forum.threads.info.tags')
                        </div>
                    </div>
                @endforeach

                <div class="text-center">
                    {!! $threads->render() !!}
                </div>
            @else
                <div class="flex flex-col items-center justify-center pt-4 text-gray-700">
                    <h2 class="text-2xl pb-4">No threads were found!</h2>
                    <a href="{{ route('threads.create') }}" 
                    class="button">
                        Create a new one
                    </a>
                </div>
            @endif
        </div>
        <div class="w-full md:w-1/4 md:pl-3 md:pt-4">
            <a href="{{ route('threads.create') }}"
            class="button button-full">
                Create Thread
            </a>

            @include('layouts._ads._forum_sidebar')

            <h3 class="text-xs font-bold tracking-wider uppercase text-gray-500 mb-4">Tags</h3>
            <ul class="tags">
                <li class="{{ active('forum*', ! isset($activeTag) || $activeTag === null) }}">
                    <a href="{{ route('forum') }}">
                        All
                    </a>
                </li>   

                @foreach (App\Models\Tag::orderBy('name')->get() as $tag)
                    <li class="{{ isset($activeTag) && $tag->matches($activeTag) ? ' active' : '' }}">
                        <a href="{{ route('forum.tag', $tag->slug()) }}">
                            {{ $tag->name() }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
