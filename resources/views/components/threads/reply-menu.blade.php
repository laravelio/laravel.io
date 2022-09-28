@props(['thread', 'reply'])

<div class="flex items-center lg:gap-x-3">
    @if ($reply->author()->isModerator() || $reply->author()->isAdmin())
        <span class="text-sm text-lio-500 border border-lio-200 rounded py-1.5 px-3 leading-none">
            moderator
        </span>
    @endif

    @can(App\Policies\ThreadPolicy::UPDATE, $thread)
        @if ($thread->isSolutionReply($reply))
            <button
                class="flex items-center font-medium text-lio-500 hover:text-gray-300"
                @click="activeModal = 'unmarkSolution-{{ $thread->id }}'"
            >
                <x-heroicon-o-check-badge class="w-6 h-6" />
                <span class="hidden lg:block lg:ml-1">Unmark Solution</span>
            </button>

            <x-modal
                identifier="unmarkSolution-{{ $thread->id }}"
                :action="route('threads.solution.unmark', $thread->slug())"
                title="Unmark As Solution"
                type="update"
            >
                <p>Confirm to unmark this reply as the solution for <strong>"{{ $thread->subject() }}"</strong>.</p>
            </x-modal>
        @else
            <button
                class="flex items-center font-medium text-gray-300 hover:text-lio-500"
                @click="activeModal = 'markSolution-{{ $reply->id }}'"
            >
                <x-heroicon-o-check-badge class="w-6 h-6" />
                <span class="hidden lg:block lg:ml-1">Mark Solution</span>
            </button>

            <x-modal
                identifier="markSolution-{{ $reply->id }}"
                :action="route('threads.solution.mark', [$thread->slug(), $reply->id()])"
                title="Mark As Solution"
                type="update"
            >
                <p>Confirm to mark this reply as the solution for <strong>"{{ $thread->subject() }}"</strong>.</p>
            </x-modal>
        @endif
    @else
        @if ($thread->isSolutionReply($reply))
            <span class="flex items-center font-medium text-lio-500">
                <x-heroicon-o-check-badge class="w-6 h-6" />
                <span>Solution</span>
            </span>
        @endif
    @endcan

    @canany([App\Policies\ReplyPolicy::UPDATE, App\Policies\ReplyPolicy::DELETE, App\Policies\ReplyPolicy::REPORT_SPAM], $reply)
        <div class="relative -mr-3" x-data="{ open: false }" @click.outside="open = false">
            <button
                class="p-2 rounded hover:bg-gray-100"
                @click="open = !open"
            >
                <x-heroicon-o-ellipsis-horizontal class="w-6 h-6" />
            </button>

            <div
                x-cloak
                x-show="open"
                class="absolute top-12 right-1 flex flex-col bg-white rounded shadow w-48 z-10"
            >
                @can(App\Policies\ReplyPolicy::UPDATE, $reply)
                    <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100" @click="edit = !edit; open = false;">
                        <x-heroicon-o-pencil class="w-6 h-6"/>
                        <span x-text="edit ? 'Cancel editing' : 'Edit'"></span>
                    </button>
                @endcan

                @can(App\Policies\ReplyPolicy::DELETE, $reply)
                    <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100" @click="activeModal = 'deleteReply-{{ $reply->id }}'">
                        <x-heroicon-o-trash class="w-6 h-6 text-red-500"/>
                        Delete
                    </button>
                @endcan

                @can(App\Policies\ReplyPolicy::REPORT_SPAM, $reply)
                    <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100" @click="activeModal = 'markAsSpam-{{ $reply->id }}'">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-500"/>
                        Mark as spam
                    </button>
                @endcan
            </div>
        </div>


        @can(App\Policies\ReplyPolicy::DELETE, $reply)
            <x-modal
                identifier="deleteReply-{{ $reply->id }}"
                :action="route('replies.delete', $reply->id())"
                title="Delete Reply"
            >
                <p>Are you sure you want to delete this reply? This cannot be undone.</p>

                @unless ($reply->isAuthoredBy(Auth::user()))
                    <div class="mt-4">
                        <x-forms.inputs.textarea name="delete_reason" label="Reason" placeholder="Optional reason that will saved in the back-end..." />
                    </div>
                @endunless
            </x-modal>
        @endcan

        @can(App\Policies\ReplyPolicy::REPORT_SPAM, $reply)
            <x-modal
                identifier="markAsSpam-{{ $reply->id }}"
                :action="route('replies.spam.mark', $reply->id)"
                title="Mark as spam"
                type="post"
            >
                <p>Are you sure this reply is spam? We'll report this to our moderators.</p>
            </x-modal>
        @endcan
    @endcanany
</div>
