<form action="{{ route(...$route) }}" method="POST">
    @csrf
    @method($method ?? 'POST')

    @formGroup('title')
        <label for="title">Title</label>
        <input 
            type="text" 
            name="title" 
            id="title" 
            value="{{ old('title', isset($series) ? $series->title() : null) }}" 
            class="form-control" 
            required maxlength="100" 
        />
        <span class="text-gray-600 text-sm mt-1">Maximum 100 characters.</span>
        @error('title')
    @endFormGroup

    @formGroup('tags')
        <label for="tags">Tags</label>

        <select name="tags[]" id="create-series" multiple x-data="{}" x-init="function () { choices($el) }">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" @if(in_array($tag->id, $selectedTags)) selected @endif>{{ $tag->name }}</option>
            @endforeach
        </select>

        @error('tags')
    @endFormGroup

    <div class="flex justify-end items-center">
        <a href="{{ isset($series) ? route('series.show', $series->id()) : route('series') }}" class="text-green-darker mr-4">Cancel</a>
        <button type="submit" class="button button-primary">{{ isset($series) ? 'Update series' : 'Create series' }}</button>
    </div>
</form>
