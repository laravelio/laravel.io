<h2>{{ $topic->title }}</h2>

<div class="postinformation">
    <time>{{ $topic->long_published_date }} </time> - {{ HTML::image($topic->author->image(16)) }} {{ $topic->author->twitter_link }} - <a href="#disqus_thread">Loading comments...</a>
</div>

{{ $topic->body }}


<div class="postnavigation">
@if($topic->previous)
    <a href="{{ $topic->previous->url }}" class="previous">Previous topic</a>
@endif

@if($topic->next)
    <a href="{{ $topic->next->url }}" class="next">Next topic</a>
@endif
</div>

@if(count($topic->tags))

    <aside>
        <ul>
            @foreach($topic->tags as $tag)
                <li>{{ $tag->link }}</li>
            @endforeach
        </ul>
    </aside>

@endif

