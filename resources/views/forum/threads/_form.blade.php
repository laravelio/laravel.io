{!! Form::open(['route' => $route, 'method' => $method ?? 'POST']) !!}
    @formGroup('subject')
        {!! Form::label('subject') !!}
        {!! Form::text('subject', isset($thread) ? $thread->subject() : null, ['class' => 'form-control', 'required', 'maxlength' => '60']) !!}
        <span class="text-gray-600 text-sm">Maximum 60 characters.</span>
        @error('subject')
    @endFormGroup

    @formGroup('body')
        {!! Form::label('body') !!}
        {!! Form::textarea('body', isset($thread) ? $thread->body() : null, ['class' => 'editor']) !!}
        @error('body')
    @endFormGroup

    @formGroup('tags')
        {!! Form::label('tags') !!}
        <multi-select 
            :initial-value="{{ $selectedTags ?? '[]' }}"
e           :options="{{ $tags }}" 
            :max="3"
            placeholder="Choose up to 3 tags" 
            label="name" 
            track-by="name"
            name="tags[]">
        </multi-select>
        @error('tags')
    @endFormGroup

    <div class="flex justify-end items-center">
        <a href="{{ isset($thread) ? route('thread', $thread->slug()) : route('forum') }}" class="text-green-darker mr-4">Cancel</a>
        {!! Form::submit(isset($thread) ? 'Update Thread' : 'Create Thread', ['class' => 'button']) !!}
    </div>
{!! Form::close() !!}
