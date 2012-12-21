<h1>Welcome to laravel.io</h1>
<p>Join us here or {{ HTML::link('http://twitter.com/laravelio', 'on twitter @laravelio') }} to participate in a global study group where we focus on one digestible topic per day</p>

<hr>

<ul class="latest">
    @foreach($recent_topics as $topic)
    	<li>
    		<time>{{ $topic->published_date }} -</time>
    		<span>{{ HTML::image($topic->author->image(16)) }} {{ $topic->author->name }} - </span>
            {{ $topic->link }}
    	</li>
    @endforeach
</ul>

@render('global.books')