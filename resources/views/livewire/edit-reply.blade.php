<div>
    <div
        x-show="!edit"
        x-data
        x-init="$nextTick(function () { highlightCode($el); }); $watch('edit', function () { highlightCode($el); });"
        class="prose prose-lio max-w-none p-6 break-words"
    >
        <x-buk-markdown>
            {!! replace_links(md_to_html($reply->body())) !!}
        </x-buk-markdown>
    </div>

    @can(App\Policies\ReplyPolicy::UPDATE, $reply)
        <div x-show="edit">
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
                    <x-forms.error class="px-6">{{ $error }}</x-forms.error>
                @endforeach
            @endif
        </div>
    @endcan

    @if (session()->has('message'))
        <x-forms.success 
            class="px-6 pb-4" 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => { show = false; edit = false; }, 3000)"
        >
            {{ session('message') }}
        </x-forms.success>
    @endif

    @if ($reply->isUpdated())
        <div class="text-sm text-gray-900 px-6 pb-6" x-show="!edit">
            Last updated

            @if ($updatedBy = $reply->updatedBy())
                by <a href="{{ route('profile', $updatedBy->username()) }}" class="text-lio-500 border-b-2 pb-0.5 border-lio-100 hover:text-lio-600">
                    {{ '@'.$reply->updatedBy()->username() }}
                </a>
            @endif

            {{ $reply->updated_at->diffForHumans() }}.
        </div>
    @endif
</div>
