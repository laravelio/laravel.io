<form action="{{ route(...$route) }}" method="POST">
    @csrf
    @method($method ?? 'POST')

    @formGroup('title')
        <label for="title">Title</label>
        <input 
            type="text" 
            name="title" 
            id="title" 
            value="{{ isset($article) ? $article->title() : null }}" 
            class="form-control" 
            required maxlength="60" 
        />
        <span class="text-gray-600 text-sm">Maximum 60 characters.</span>
        @error('title')
    @endFormGroup

    @formGroup('body')
        <label for="body">Body</label>

        @include('_partials._editor', [
            'content' => isset($article) ? $article->body() : null
        ])
        
        @error('body')
    @endFormGroup

    @formGroup('tags')
        <label for="tags">Tags</label>

        <select name="tags[]" id="create-article" multiple x-data="{}" x-init="function () { choices($el) }">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" @if(in_array($tag->id, $selectedTags)) selected @endif>{{ $tag->name }}</option>
            @endforeach
        </select>

        @error('tags')
    @endFormGroup

    @if($series->count() > 0)
        @formGroup('series')
            <label for="series">Series</label>

            <select name="series">
                <option value="">Select a series</option>
                @foreach($series as $s)
                    <option value="{{ $s->id }}" @if(isset($article) && $article->series_id === $s->id) selected @endif>{{ $s->title }}</option>
                @endforeach
            </select>

            @error('tags')
        @endFormGroup
    @endif

    <div class="flex justify-end items-center">
        <a href="{{ isset($article) ? route('articles.show', $article->slug()) : route('articles') }}" class="text-green-darker mr-4">Cancel</a>
        <button type="submit" class="button button-primary">{{ isset($article) ? 'Update Article' : 'Create Article' }}</button>
    </div>
</form>
