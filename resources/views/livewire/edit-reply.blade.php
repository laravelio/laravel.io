<div>
    <div
        x-show="!edit"
        x-data="{}"
        x-init="$nextTick(function () { highlightCode($el); })"
        class="prose prose-lio max-w-none p-6 break-words"
    >
        <x-buk-markdown>
            {{ $reply->body() }}
        </x-buk-markdown>
    </div>

    <x-buk-form x-show="edit" wire:submit.prevent="update(Object.fromEntries(new FormData($event.target)))" action="#">
        <livewire:editor 
            x-cloak
            :hasShadow="false"
            :body="$reply->body()"
            hasMentions
            hasButton
            buttonLabel="Update reply"
            buttonIcon="heroicon-o-arrow-right"    
        />

        @if ($errors->has('body'))
            @foreach ($errors->get('body') as $error)
                <p class="p-6 text-sm text-red-600">{{ $error }}</p>
            @endforeach
        @endif
    </x-buk-form>
</div>
