@if($topic->previous)
    <a href="{{ $topic->previous->url }}" class="arrow left"></a>
@endif

@render('topics._topic', array('topic' => $topic))

@if($topic->next)
    <a href="{{ $topic->next->url }}" class="arrow right"></a>
@endif

@render('layouts._disqus_comments')