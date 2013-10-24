<h1>Forum Category {{ $category->title }}</h1>

<p>{{ $category->description }}</p>

<a href="{{ action('ForumController@getCreateThread', [$category->slug]) }}">Create a Thread</a>

@if($threads->count() > 0)
    <ul>
        @foreach($threads as $thread)
            <li>
                <a href="{{ $thread->forumThreadUrl }}">{{ $thread->title }}</a> - <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a> - {{ $thread->created_at }}
                
                {{ $thread->child_count }}
                
                @if($thread->mostRecentChild)
                	<span>Most Recent Reply at {{ $thread->mostRecentChild->created_at }} by <a href="{{ $thread->mostRecentChild->author->profileUrl }}">{{ $thread->mostRecentChild->author->name }}</a></span>
                @endif
            </li>
        @endforeach
    </ul>

    {{ $threads->links() }}
@else
    There are no posts, yet.
@endif