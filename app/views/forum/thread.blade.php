<div class="row">
    <div class="small-12 columns comments">
        @foreach($comments as $comment)
            <div class="comment">
                @if($comment->id == $thread->id)
                    <h2>{{ $comment->title }}</h2>
                    @foreach($comment->tags as $tag)
                        <a href="">{{ $tag->name }}</a>
                    @endforeach
                    <p>{{ $comment->body }}</p>
                    <span class="meta"><a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></span>
                    <h3>Replies</h3>
                @else
                    <p>{{ $comment->body }}</p>
                    <span class="meta"><a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></span>
                @endif

            </div>
        @endforeach
    </div>
</div>

{{ $comments->links() }}

<div class="row">
    <div class="small-12 columns form">

        {{ Form::open() }}

            <fieldset>
                <legend>Reply</legend>

                <div class="row">
                    <div>
                        <div id="markdown_editor"></div>
                        {{ Form::textarea('body', null, ['id' => '_markdown_textarea', 'style' => 'display: none;']) }}
                        {{ $errors->first('body', '<small class="error">:message</small>') }}
                        {{ Form::button('Reply', ['type' => 'submit', 'class' => 'button']) }}
                    </div>
                </div>
            </fieldset>

        {{ Form::close() }}
    </div>
</div>

@include('layouts._markdown_editor')