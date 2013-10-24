<div class="row">
    <div class="small-12 columns">
        <h2>Edit Article</h2>

        {{ Form::model($article->resource) }}

        @include('articles._article_form')

        {{ Form::close() }}

    </div>
</div>