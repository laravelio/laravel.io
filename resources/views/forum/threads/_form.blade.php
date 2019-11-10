<form action="{{ route(...$route) }}" method="POST">
    @csrf
    @method($method ?? 'POST')

    @formGroup('subject')
        <label for="subject">Subject</label>
        <input type="text" name="subject" id="subject" value="{{ isset($thread) ? $thread->subject() : null }}" class="form-control" required maxlength="60" />
        <span class="text-gray-600 text-sm">Maximum 60 characters.</span>
        @error('subject')
    @endFormGroup

    @formGroup('body')
        <label for="body">Body</label>
        <editor
            name="body"
            id="body"
            content="{{ isset($thread) ? $thread->body() : null }}"
        />
        @error('body')
    @endFormGroup

    @formGroup('tags')
        <label for="tags">Tags</label>
        <multi-select 
            :initial-value="{{ $selectedTags ?? '[]' }}"
e           :options="{{ $tags }}" 
            :max="3"
            placeholder="Choose up to 3 tags" 
            label="name" 
            track-by="name"
            name="tags[]"
            identifier="create-thread">
            @php($selected = isset($thread) ? $thread->tags()->pluck('id')->toArray() : [])
            <select name="tags[]" id="create-thread" class="hidden" multiple>
                @foreach($tags->toArray() as $tag)
                    <option value="{{ $tag['id'] }}" @if(in_array($tag['id'], $selected)) selected @endif>{{ $tag['name'] }}</option>
                @endforeach
            </select>
        </multi-select>
        @error('tags')
    @endFormGroup

    <div class="flex justify-end items-center">
        <a href="{{ isset($thread) ? route('thread', $thread->slug()) : route('forum') }}" class="text-green-darker mr-4">Cancel</a>
        <button type="submit" class="button button-primary">{{ isset($thread) ? 'Update Thread' : 'Create Thread' }}</button>
    </div>
</form>
