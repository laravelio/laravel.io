<article>

    <h1>Welcome to laravel.io</h1>

    <p>Laravel: Ins and Outs is a project created and maintained by the {{ HTML::link('http://laravel.com/irc', '#Laravel community on irc.freenode.net') }}. Our focus is to provide regular study topics that will grow our combined knowledge of the Laravel framework.</p>

    <p>Join us here or on twitter {{ HTML::link('http://twitter.com/laravelio', '@laravelio') }} to participate in a global study group where we focus on two digestible topics per week.</p>

    <section class="recent-topics">
    RECENT TOPICS
    </section>

    <ul class="latest">
        @foreach($recent_topics as $topic)
            <li>
                <time>{{ $topic->short_published_date }} -</time>

                @if($topic->author)
                    <span>{{ HTML::image($topic->author->image(16)) }} {{ $topic->author->twitter_link }}
                @endif

                - </span>
                {{ $topic->link }}
            </li>
        @endforeach
    </ul>

</article>