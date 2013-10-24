<div class="row">
    <div class="small-12 columns">
        <h2>Compose Article</h2>

        {{ Form::open() }}

        @include('articles._article_form')

        {{ Form::close() }}

    </div>
</div>