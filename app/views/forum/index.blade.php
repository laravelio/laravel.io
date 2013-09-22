<h1>Forum</h1>

<p>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
</p>

<ul>
    @foreach($categories as $category)
        <li>
            <a href="{{ $category->categoryIndexUrl }}">{{ $category->title }}</a>
            <span>thread count {{ $category->child_count }}</span>

            @if($category->mostRecentChild)
                Newest Thread: <a href="{{ $category->mostRecentChild->forumThreadUrl }}">{{ $category->mostRecentChild->title }}</a> by <a href="{{ $category->mostRecentChild->author->profileUrl }}">{{ $category->mostRecentChild->author->name }}</a>
            @endif
        </li>
    @endforeach
</ul>