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

        @include('_partials._editor', [
            'content' => isset($thread) ? $thread->body() : null
        ])

        @error('body')
    @endFormGroup

    @formGroup('tags')
        <label for="tags">Tags</label>

        <select name="tags[]" id="create-thread" multiple x-data="{}" x-init="function () { choices($el) }">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" @if(in_array($tag->id, $selectedTags)) selected @endif>{{ $tag->name }}</option>
            @endforeach
        </select>

        @error('tags')
    @endFormGroup

    <div class="flex justify-end items-center">
        <a href="{{ isset($thread) ? route('thread', $thread->slug()) : route('forum') }}" class="text-lio-700 mr-4">Cancel</a>
        <button type="submit" class="button button-primary">{{ isset($thread) ? 'Update Thread' : 'Create Thread' }}</button>
    </div>
</form>
