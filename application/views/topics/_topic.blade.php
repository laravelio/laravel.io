<h2>{{ $topic->title }}</h2>

<hr>

<div class="postinformation">
    <time>{{ $topic->long_published_date }} </time> - {{ HTML::image($topic->author->image(16)) }} {{ $topic->author->twitter_link }} <!-- - <a href="#disqus_thread">Loading comments...</a>-->
</div>

<hr>

{{ $topic->body }}

@if($topic->tags)
    <aside>
        <ul>
            @foreach($topic->tags as $tag)
                <li>{{ $tag->link }}</li>
            @endforeach
        </ul>
    </aside>
@endif