@title('Something went wrong')

@extends('layouts.base')

@section('body')
    <div class="jumbotron text-center">
        <h1>{{ $title }}</h1>
        <p>
            We've been notified and will try to fix the problem as soon as possible.
            Please <a href="https://github.com/laravelio/portal/issues/new">open a Github issue</a> if the problem persists.
        </p>
    </div>
@endsection
