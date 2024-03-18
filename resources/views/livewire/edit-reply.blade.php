<div>
    <div
        x-show="!edit"
        x-data
        x-init="
            $nextTick(function () {
                highlightCode($el)
            })
            $watch('edit', function () {
                highlightCode($el)
            })
            $wire.on('replyEdited', function () {
                show = true
                edit = false
            })
        "
        class="prose-lio prose max-w-none break-words p-6"
    >
        {!! replace_links(md_to_html($reply->body())) !!}
    </div>

    @can(App\Policies\ReplyPolicy::UPDATE, $reply)
        <div
            x-show="edit"
            @submitted.stop="$wire.updateReply($event.detail.body)"
        >
            <livewire:editor
                x-cloak
                :hasShadow="false"
                :body="$reply->body()"
                hasMentions
                hasButton
                buttonLabel="Update reply"
                buttonIcon="heroicon-o-arrow-right"
                cancelAction='@click="edit = false; open = false;"'
            />

            @if ($errors->has('body'))
                @foreach ($errors->get('body') as $error)
                    <x-forms.error class="px-6 pb-4">
                        {{ $error }}
                    </x-forms.error>
                @endforeach
            @endif
        </div>
    @endcan

    @if ($reply->isUpdated())
        <div class="px-6 pb-6 text-sm text-gray-900" x-show="!edit">
            Last updated

            @if ($updatedBy = $reply->updatedBy())
                by
                <a
                    href="{{ route('profile', $updatedBy->username()) }}"
                    class="border-b-2 border-lio-100 pb-0.5 text-lio-500 hover:text-lio-600"
                >
                    {{ '@' . $reply->updatedBy()->username() }}
                </a>
            @endif

            {{ $reply->updated_at->diffForHumans() }}.
        </div>
    @endif
</div>
