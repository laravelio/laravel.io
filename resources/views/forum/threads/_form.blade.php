<x-buk-form action="{{ route(...$route) }}" :method="$method ?? 'POST'">
    <div class="bg-gray-100 py-6 px-4 space-y-6 sm:p-6">
        <div>
            <h2 id="create_thread_heading" class="text-lg leading-6 font-medium text-gray-900">
                Create a new thread
            </h2>
        </div>

        <div class="flex flex-col space-y-6">
            <div class="flex-grow space-y-6">
                <div class="space-y-1">
                    <x-forms.label for="subject"/>

                    <x-forms.inputs.input name="subject" :value="isset($thread) ? $thread->subject() : null" required maxlength="60" />

                    <span class="mt-2 text-sm text-gray-500">
                        Maximum 60 characters.
                    </span>
                </div>
            </div>

            <div class="flex-grow space-y-6">
                <div class="space-y-1">
                    <x-forms.label for="tags">Tags</x-forms.label>

                    <select name="tags[]" id="create-thread" multiple x-data="{}" x-init="function () { choices($el) }">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @if(in_array($tag->id, $selectedTags)) selected @endif>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex-grow space-y-6">
                <div class="space-y-1">
                    <x-forms.label for="body">Compose your question</x-forms.label>

                    <livewire:editor 
                        :body="isset($thread) ? $thread->body() : null" 
                        placeholder="Compose your thread..."
                        hasButton
                        :buttonLabel="isset($thread) ? 'Update thread' : 'Create thread'"
                        buttonIcon="heroicon-o-arrow-right"
                    />
                </div>
            </div>
        </div>
    </div>
</x-buk-form>
