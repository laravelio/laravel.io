<h1><a href="{{ $thread->owner->categoryIndexUrl }}">Forum Category {{ $thread->owner->title }}</a></h1>

<p>{{ $thread->owner->description }}</p>

<hr/>

<h2>{{ $thread->title }}</h2>
<p>
    {{ $thread->body }}
</p>

<ul>
@foreach($thread->children as $child)
    <li>
        {{ $child->author->name }}

        <p>
            {{ $child->body }}
        </p>
    </li>
@endforeach
</ul>

<div class="row">
    <div class="small-12 columns">

        {{ Form::open() }}

            <fieldset>
                <legend>Reply</legend>

                <div class="row">
                    <div class="small-1 columns">
                        {{ Form::textarea('body') }}
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