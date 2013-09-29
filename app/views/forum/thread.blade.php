<h1><a href="{{ $category->categoryIndexUrl }}">Forum Category {{ $category->title }}</a></h1>

<p>{{ $category->description }}</p>

<hr/>

<ul>
    @foreach($comments as $comment)
        <li>
            @if($comment->id == $thread->id)
                <h2>{{ $comment->title }}</h2>
            @endif
            <p>
                {{ $comment->body }}

                <span>- <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></span>
            </p>
        </li>
    @endforeach

    {{ $comments->links() }}
</ul>

<div class="row">
    <div class="small-12 columns">

        {{ Form::open() }}

            <fieldset>
                <legend>Reply</legend>

                <div class="row">
                    <div class="">
                        <div id="markdown_editor"></div>
                        {{ Form::textarea('body', null, ['id' => '_markdown_textarea', 'style' => 'display: none;']) }}
                        {{ $errors->first('body', '<small class="error">:message</small>') }}
                    </div>
                </div>
            </fieldset>

            <div class="row">
                <div class="large-12 columns">
                    {{ Form::button('Reply', ['type' => 'submit']) }}
                </div>
            </div>

        {{ Form::close() }}
    </div>
</div>

@include('layouts._markdown_editor')