@title('Create your thread')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <hr>

    <div class="alert alert-info">
        <p>
            Please read our <a href="#" class="alert-link">Forum Rules</a> and
            <a href="https://github.com/laravelio/portal/blob/master/code_of_conduct.md" class="alert-link">Code of Conduct</a>
            before creating a thread.
        </p>
    </div>

    @include('forum.threads._form', ['route' => 'threads.store'])
@endsection
