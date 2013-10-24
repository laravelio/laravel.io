@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <section class="forum">
        <h1>Forum</h1>
        @if(Input::has('tags'))
            <h2>Posts tagged with {{ Input::get('tags') }}</h2>
        @endif

        @if($threads->count() > 0)
            @foreach($threads as $thread)
                @include('forum._thread_summary')
            @endforeach

            {{ str_replace('%2C', ',', $threads->links()) }}
        @else
            <div class="">
                There are currently no threads for the selected category.
            </div>
        @endif
    </section>
@stop