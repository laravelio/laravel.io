<div class="search">
    {!! Form::open(['action' => 'Forum\ForumThreadsController@getSearch', 'method' => 'GET']) !!}
        {!! Form::text('query', isset($query) ? $query : '', ['placeholder' => 'search the laravel.io forum']) !!}
    {!! Form::close() !!}
</div>

<ul>
    {{-- $forumSections is set in the constructor of the ForumController class --}}
    @foreach ($forumSections as $sectionTitle => $attributes)
        <li>
            <a {{ isset($attributes['active']) ? 'class="active"' : null  }} href="{{ action('Forum\ForumThreadsController@getIndex') }}{{ $attributes['tags'] ? '?tags=' . $attributes['tags'] : '' }}">{{ $sectionTitle }}
            </a>
        </li>
    @endforeach
</ul>
