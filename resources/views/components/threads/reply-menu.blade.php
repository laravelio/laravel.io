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
                class="flex items-center gap-x-2 font-medium text-lio-500 hover:text-gray-300"
                @click="activeModal = 'unmarkSolution-{{ $thread->id }}'"
            >
                <x-heroicon-o-badge-check class="w-6 h-6" />
                <span class="hidden lg:block">Unmark Solution</span>
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
                class="flex items-center gap-x-2 font-medium text-gray-300 hover:text-lio-500"
                @click="activeModal = 'markSolution-{{ $reply->id }}'"
            >
                <x-heroicon-o-badge-check class="w-6 h-6" />
                <span class="hidden lg:block">Mark Solution</span>
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
            <span class="flex items-center gap-x-2 font-medium text-lio-500">
                <x-heroicon-o-badge-check class="w-6 h-6" />
                <span>Solution</span>
            </span>
        @endif
    @endcan

    @can(App\Policies\ReplyPolicy::UPDATE, $reply)
        <div class="relative -mr-3" x-data="{ open: false }" @click.outside="open = false">

            <button
                class="p-2 rounded hover:bg-gray-100"
                @click="open = !open"
            >
                <x-heroicon-o-dots-horizontal class="w-6 h-6" />
            </button>

            <div
                x-cloak
                x-show="open"
                class="absolute top-12 right-1 flex flex-col bg-white rounded shadow w-48"
            >

                <a class="flex gap-x-2 p-3 rounded hover:bg-gray-100" href="{{ route('replies.edit', $reply->id()) }}">
                    <x-heroicon-o-pencil class="w-6 h-6"/>
                    Edit
                </a>

                <button class="flex gap-x-2 p-3 rounded hover:bg-gray-100" @click="activeModal = 'deleteReply-{{ $reply->id }}'">
                    <x-heroicon-o-trash class="w-6 h-6 text-red-500"/>
                    Delete
                </button>
            </div>
        </div>

        <x-modal
                identifier="deleteReply-{{ $reply->id }}"
                :action="route('replies.delete', $reply->id())"
                title="Delete Reply"
            >
            <p>Are you sure you want to delete this reply? This cannot be undone.</p>
        </x-modal>
    @endcan
</div>
