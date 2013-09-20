<h1>Forum Category {{ $category->title }}</h1>

<p>{{ $category->description }}</p>

<a href="{{ action('Controllers\ForumController@getCreateThread', [$category->slug]) }}">Create a Thread</a>

@if($category->rootThreads->count() > 0)
    <ul>
        @foreach($category->rootThreads as $thread)
            <li>
                <a href="{{ $thread->forumThreadUrl }}">{{ $thread->title }}</a> - {{ $thread->author->name }} - {{ $thread->created_at }}
                @if($thread->mostRecentChild)
                	<span>Most Recent Reply at {{ $thread->mostRecentChild->created_at }} by {{ $thread->mostRecentChild->author->name }}</span>
                @endif
            </li>
        @endforeach
    </ul>
@else
    There are no posts, yet.
@endif