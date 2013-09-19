<h1>Forum Category {{ $category->title }}</h1>

<p>{{ $category->description }}</p>

<a href="{{ action('Controllers\ForumController@getCreateThread', [$category->slug]) }}">Create a Thread</a>

@if($category->rootThreads->count() > 0)
    <ul>
        @foreach($category->rootThreads as $thread)
        {{ $thread->forumThreadUrl }}
            <li>
                <a href="{{ $thread->forumThreadUrl }}">{{ $thread->title }}</a>
            </li>
        @endforeach
    </ul>
@else
    There are no posts, yet.
@endif