<form action="{{ route(...$route) }}" method="POST" x-data="{ showAdvanced: false }">
    @csrf
    @method($method ?? 'POST')

    <div class="px-4 pt-4">
        @formGroup('title')
            <label for="title">Title</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                value="{{ old('title', isset($article) ? $article->title() : null) }}" 
                class="form-control" 
                required maxlength="100" 
            />
            <span class="text-gray-600 text-sm mt-1">Maximum 100 characters.</span>
            @error('title')
        @endFormGroup

        @formGroup('body')
            <label for="body">Body</label>

            @include('_partials._editor', [
                'content' => isset($article) ? $article->body() : null
            ])
            
            @error('body')
        @endFormGroup
    </div>

    <div x-show="showAdvanced" x-cloak class="px-4 pt-4 border-t-2">
        @formGroup('original_url')
            <label for="original_url">Original URL</label>
            <input 
                type="text" 
                name="original_url" 
                id="original_url" 
                value="{{ old('original_url', isset($article) ? $article->originalUrl() : null) }}" 
                class="form-control" 
            />
            <span class="text-gray-600 text-sm mt-1">If you have already posted this article on your own site, enter the URL here and the content will be attributed to you.</span>
            @error('original_url')
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

                <select name="series" x-data="{}" x-init="function () { choices($el) }">
                    <option value="">Select a series</option>
                    @foreach($series as $s)
                        <option value="{{ $s->id }}" @if($selectedSeries == $s->id) selected @endif>{{ $s->title }}</option>
                    @endforeach
                </select>

                @error('tags')
            @endFormGroup
        @endif
    </div>

    <div class="px-4 pb-4">
        <button 
            type="button" 
            class="text-green-darker" 
            @click="showAdvanced = !showAdvanced" 
            x-text="showAdvanced ? 'Hide advanced options' : 'Show advanced options'"
        ></button>

        <div class="flex justify-end items-center">
            <a href="{{ isset($article) ? route('articles.show', $article->slug()) : route('articles') }}" class="text-green-darker mr-4">Cancel</a>
            <button type="submit" class="button button-primary">{{ isset($article) ? 'Update Article' : 'Create Article' }}</button>
        </div>
    </div>
</form>
